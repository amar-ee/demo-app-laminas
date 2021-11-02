<?php

declare(strict_types=1);

namespace Album\Controller;

use Album\Hydrator\AlbumHydrator;
use Album\Repository\AlbumRepository;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Album\Form\AlbumForm;
use Album\Model\Album as AlbumModel;
use Album\Entity\Album as AlbumEntity;
use Album\Service\AlbumService;

class AlbumController extends AbstractActionController
{
    /**
     * @var AlbumService
     */
    private $albumService;

    /**
     * @var AlbumHydrator
     */
    private $albumHydrator;

    /**
     * @param
     */
    public function __construct(AlbumService $albumService, AlbumHydrator $albumHydrator)
    {
        $this->albumService = $albumService;
        $this->albumHydrator = $albumHydrator;
    }

    /**
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $albumRepo = $this->albumService->findAllAlbums();
        return new ViewModel([
            'albums' => $albumRepo->getArrayResult(),
        ]);
    }

    /**
     * @return Response|AlbumForm[]
     */
    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add Album');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $album = new AlbumModel();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $data = $form->getData();
        $albumObj = new AlbumEntity();
        $albumData = $this->albumHydrator->hydrate($data, $albumObj);
        $this->albumService->saveAlbum($albumData);

        return $this->redirect()->toRoute('album');
    }

    /**
     * @return Response|ViewModel
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        /* Retrieve the album with the specified id. Doing so raises
        an exception if the album is not found, which should result
        in redirecting to the landing page. */
        try {
            $album = $this->albumService->findOneById($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->setData($this->albumHydrator->extract($album));
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $data = $form->getData();
            $album = $this->albumHydrator->hydrate($data, $album);
            $this->albumService->saveAlbum($album);
        } catch (\Exception $e) {
        }

        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    /**
     * @return array|Response
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->albumService->deleteAlbum(
                    $this->albumService->findOneById($id)
                );
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->albumService->findOneById($id),
        ];
    }
}
