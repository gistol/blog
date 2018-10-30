import Home from './components/Home';
import Post from './components/Post';
import Login from './components/Login';
import Page from './components/Page';

export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/page/:slug(.+)-:id(.+)',
        name: 'page',
        component: Page
    },
    {
        path: '/:slug(.+)-:id(.+)',
        name: 'post',
        component: Post
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
];