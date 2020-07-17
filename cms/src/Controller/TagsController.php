<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        
        $tags = $this->paginate($this->Tags);

        $this->set(compact('tags'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Articles'],
        ]);
        
        try
        {
            $this->Authorization->authorize($tag);

            $this->set(compact('tag'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to view this tag titled: " . $tag->title));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tag = $this->Tags->newEmptyEntity();
        
        try
        {
            $this->Authorization->authorize($tag);
            if ($this->request->is('post')) {
                $tag = $this->Tags->patchEntity($tag, $this->request->getData());
                if ($this->Tags->save($tag)) {
                    $this->Flash->success(__('The tag has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The tag could not be saved. Please, try again.'));
            }
            $articles = $this->Tags->Articles->find('list', ['limit' => 200]);
            $this->set(compact('tag', 'articles'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to create new tags "));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tag = $this->Tags->get($id, [
            'contain' => ['Articles'],
        ]);
        
        try
        {
            $this->Authorization->authorize($tag);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $tag = $this->Tags->patchEntity($tag, $this->request->getData());
                if ($this->Tags->save($tag)) {
                    $this->Flash->success(__('The tag has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The tag could not be saved. Please, try again.'));
            }
            $articles = $this->Tags->Articles->find('list', ['limit' => 200]);
            $this->set(compact('tag', 'articles'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to update this tag titled: " . $tag->title));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
        
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        
        try
        {
            $this->Authorization->authorize($tag);
            if ($this->Tags->delete($tag)) {
                $this->Flash->success(__('The tag has been deleted.'));
            } else {
                $this->Flash->error(__('The tag could not be deleted. Please, try again.'));
            }
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to delete this tag titled: " . $tag->title));
            } else {
                $this->Flash->error($ex->getMessage());
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
