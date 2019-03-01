<template>
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>
                Task Runner
            </h3>
            <strong>TS</strong>
        </div>
        <ul class="list-unstyled components">
            <li>
                <router-link to="/vue/task">
                    <i class="glyphicon glyphicon-export"></i>
                    Create new task
                </router-link>
            </li>
            <li>
                <router-link to="/vue/taskList">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    Task list
                </router-link>
            </li>
        </ul>
        <ul class="list-unstyled CTAs">
            <li><a href="https://docs.dataforseo.com/"
                   class="download">Open documentation</a>
            </li>
        </ul>
    </nav>
</template>
<script>
    export default {
        data(){
            return {

            }
        },
    }
</script>
