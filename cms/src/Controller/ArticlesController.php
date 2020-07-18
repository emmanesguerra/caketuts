<?php

namespace App\Controller;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        
        $this->loadComponent('Paginator');
        $articles = $this->Paginator->paginate($this->Articles->find()->contain(['Users']));
        $this->set(compact('articles'));
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($slug = null)
    {
        $this->Authorization->skipAuthorization();
        
        $article = $this->Articles
                    ->findBySlug($slug)
                    ->contain(['Users', 'Tags'])
                    ->firstOrFail();
        $this->set(compact('article'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        
        try
        {
            $this->Authorization->authorize($article);

            if ($this->request->is('post')) {
                $article = $this->Articles->patchEntity($article, $this->request->getData());

                $article->user_id = $this->request->getAttribute('identity')->getIdentifier();

                if ($this->Articles->save($article)) {
                    $this->Flash->success(__('The article has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
            // Get a list of tags.
            $tags = $this->Articles->Tags->find('list');

            // Set tags to the view context
            $this->set('tags', $tags);

            $this->set(compact('article'));
        } catch (Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to update this article titled: " . $article->title));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($slug = null)
    {
        $article = $this->Articles
                    ->findBySlug($slug)
                    ->contain('Tags')
                    ->firstOrFail();
        
        try
        {
            $this->Authorization->authorize($article);

            if ($this->request->is(['post', 'put'])) {
                $article = $this->Articles->patchEntity($article, $this->request->getData(), [
                    'accessibleFields' => ['user_id' => false]
                ]);
                if ($this->Articles->save($article)) {
                    $this->Flash->success(__('The article has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
            // Get a list of tags.
            $tags = $this->Articles->Tags->find('list');

            // Set tags to the view context
            $this->set('tags', $tags);
            $this->set(compact('article'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to update this article titled: " . $article->title));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($slug = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $article = $this->Articles->findBySlug($slug)->firstOrFail();
        
        try
        {
            $this->Authorization->authorize($article);

            if ($this->Articles->delete($article)) {
                $this->Flash->success(__('The article has been deleted.'));
            } else {
                $this->Flash->error(__('The article could not be deleted. Please, try again.'));
            }
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to delete this article titled: " . $article->title));
            } else {
                $this->Flash->error($ex->getMessage());
            }
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function tags(...$tags)
    {
        $this->Authorization->skipAuthorization();
        
        // Use the ArticlesTable to find tagged articles.
        $articles = $this->Articles->find('tagged', [
            'tags' => $tags
        ]);

        // Pass variables into the view template context.
        $this->set([
            'articles' => $articles,
            'tags' => $tags
        ]);
    }
}
