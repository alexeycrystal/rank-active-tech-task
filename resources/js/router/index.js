import Vue from 'vue';
import VueRouter from 'vue-router';


import App from '../App';
import Task from '../views/Task';
import TaskList from '../views/TaskList';

Vue.use(VueRouter);


let routeWatcher = "/vue";
const router =  new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'initial',
            component: App,
        },
        {
            path: routeWatcher + '/task',
            name: 'task',
            component: Task,
        },
        {
            path: routeWatcher + '/taskList',
            name: 'taskList',
            component: TaskList,
        }
    ]
});

export default router;