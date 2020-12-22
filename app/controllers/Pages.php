<?php
class Pages extends Controller
{

    public function __construct()
    {

    }
    public function index()
    {
        if (isLoggedIn()) {

            redirect('posts/');
        }

        $this->view('pages/index',
            ['title_page' => 'INDEX PAGE']);
    }

    public function about()
    {
        $this->view('pages/about',
            ['title_page' => 'ABOUT PAGE']);
    }
}
