<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        try
        {
            $this->Authorization->authorize($this->request->getSession()->read('Auth'));

            $users = $this->paginate($this->Users);

            $this->set(compact('users'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to access user module"));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect([ 'controller' => 'Articles', 'action' => 'index']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Articles'],
        ]);
        
        try
        {
            $this->Authorization->authorize($user);

            $this->set(compact('user'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to view this user details"));
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
        $user = $this->Users->newEmptyEntity();
        
        try
        {
            $this->Authorization->authorize($user);
            if ($this->request->is('post')) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $this->set(compact('user'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to create new users"));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
        
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        
        try
        {
            $this->Authorization->authorize($user);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('The user has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $this->set(compact('user'));
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to update this user"));
            } else {
                $this->Flash->error($ex->getMessage());
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        
        try 
        {
            $this->Authorization->authorize($user);
            if ($this->Users->delete($user)) {
                $this->Flash->success(__('The user has been deleted.'));
            } else {
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }
        } catch (\Exception $ex) {
            if($ex->getCode() == 403) {
                $this->Flash->error(__("You're not allowed to delete this user"));
            } else {
                $this->Flash->error($ex->getMessage());
            }
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Articles',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }
    
    public function logout()
    {
        $this->Authorization->skipAuthorization();
        
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
}
