<?php

class Posts extends Controller
{

    public function __construct()
    {
        if (!isLoggedIn()) {

            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        //get post
        $posts = $this->postModel->getPosts();

        $data = [
            'title_page' => 'POSTS INDEX PAGE',
            'posts' => $posts];

        $this->view('/posts/index', $data);
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = ['title_page' => 'POSTS ADD PAGE',
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''];

            //validate data
            if (empty($data['title'])) {
                $data['title_err'] = "Please enter a title";
            }
            if (empty($data['body'])) {
                $data['body_err'] = "Please enter a body";
            }

            //make sure no errors
            if (empty($data['title_err']) && empty($data['body_err'])) {

                if ($this->postModel->addPost($data)) {

                    flash('post_message', 'Post Added');
                    redirect('posts/');
                }
            } else {

                $this->view('/posts/add', $data);
            }

        } else {

            //die("naa sa else");
            $data = ['title_page' => 'POSTS ADD PAGE',
                'title' => '',
                'body' => ''];

            $this->view('/posts/add', $data);
        }

    }

    //edit data
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title_page' => 'POSTS EDIT PAGE',
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''];

            //validate data
            if (empty($data['title'])) {
                $data['title_err'] = "Please enter a title";
            }
            if (empty($data['body'])) {
                $data['body_err'] = "Please enter a body";
            }

            //make sure no errors
            if (empty($data['title_err']) && empty($data['body_err'])) {

                if ($this->postModel->updatePost($data)) {

                    flash('post_message', 'Post Updated');
                    redirect('posts');
                } else {
                    die("Something went wrong");
                }
            } else {

                $this->view('/posts/edit', $data);
            }

        } else {

            //get existing post from model
            $post = $this->postModel->getPostById($id);

            //check for owner
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts/');
            }

            $data = ['title_page' => 'POSTS EDIT PAGE',
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body];

            $this->view('/posts/edit', $data);
        }
    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);

        $data = ['title_page' => 'SHOW POSTS PAGE',
            'post' => $post,
            'user' => $user];

        $this->view('/posts/show', $data);
    }

    public function delete($id)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if ($this->postModel->deletePost($id)) {

                flash('post_message', 'Post Removed');
                redirect('posts');
            } else {
                die("Something went wrong");
            }
        } else {

            die("else");
        }
    }
}
