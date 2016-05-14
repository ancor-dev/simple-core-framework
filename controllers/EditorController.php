<?php
/**
 * Created by Anton Korniychuk <ancor.dev@gmail.com>.
 */
namespace controllers;

use core\Core;
use models\PageORM;

/**
 * Editor. Can edit title, meta-keywords, meta-description data
 * @package controllers
 */
class EditorController extends ControllerBase
{
    /**
     * Editor main page
     */
    public function indexAction()
    {
        $this->setPageTitle('Pages');

        $pages = PageORM::findAll();

        return $this->render('editor/index', [
            'pages' => $pages,
        ]);
    } // end indexAction()

    /**
     * Edit one page
     */
    public function updateAction()
    {
        $id = Core::$app->request->query('id');
        $page = PageORM::findOneByPk($id);

        if (!$page) {
            Core::$app->httpError(404, 'Page not found');
        }

        if (Core::$app->request->isPost()) {
            $page->load(Core::$app->request->body('Page'), ['title', 'description', 'keywords']);

            if ($page->validate()) {
                if ($page->save()) {
                    Core::$app->session->flash->add('success', 'Page updated successful');
                    Core::$app->redirect(Core::$app->url->urlToRoute('admin', 'editor'));
                } else {
                    Core::$app->session->flash->add('warning', 'Could not update the page');
                }
            }
        }

        return $this->render('editor/update', [
            'page' => $page,
        ]);
    } // end updateAction()

    /**
     * Delete the page
     */
    public function deleteAction()
    {
        $id = Core::$app->request->query('id');
        $page = PageORM::findOneByPk($id);

        if (!$page) {
            Core::$app->httpError(404, 'Page not found');
        }

        if ($page->delete()) {
            Core::$app->session->flash->add('success', 'Page removed successful');
        } else {
            Core::$app->session->flash->add('warning', 'Could not delete the page');
        }

        Core::$app->redirect(Core::$app->url->urlToRoute('admin', 'editor', 'index'));
    } // end deleteAction()

    /**
     * Create new page
     */
    public function createAction()
    {
        $page = new PageORM();

        if (Core::$app->request->isPost()) {
            $page->load(Core::$app->request->body('Page'), ['name', 'title', 'description', 'keywords']);

            if ($page->validate()) {
                if ($page->save()) {
                    Core::$app->session->flash->add('success', 'Page created successful');
                    Core::$app->redirect(Core::$app->url->urlToRoute('admin', 'editor'));
                } else {
                    Core::$app->session->flash->add('warning', 'Could not create the page');
                }
            }
        }

        return $this->render('editor/create', [
            'page' => $page,
        ]);
    } // end createAction()
}
// 1. Создать форму - ok
// 2. Вывести ошибки в полях - ok
// 3. Вывести сообщения - ok
// Создание готово

// Дальше:
// 1. Подтверждение удаления, удаление - ok
// 2. Страница редактирование
// 3. Прописать во все html страницы вызов
