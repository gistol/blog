import Home from './components/Home';
import About from './components/About';
import Post from './components/Post';
import Login from './components/Login';

export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/contact',
        name: 'contact',
        component: About,
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