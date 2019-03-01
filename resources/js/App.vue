<template>
    <div class="wrapper">
        <!-- Sidebar Holder -->
        <LeftNavBar/>

        <!-- Page Content Holder -->
        <div id="content">

            <HeaderNavBar/>
            <div>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    import LeftNavBar from './components/LeftNavBar';
    import HeaderNavBar from './components/HeaderNavBar';

    export default {
        name: 'App',
        data(){
            return {

            }
        },
        components: {
            LeftNavBar,
            HeaderNavBar
        },
        mounted() {
            $(document).ready(function () {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                    $(this).toggleClass('active');
                });
            });
            this.$router.push('/vue/task')
        }
    }
</script>
<style>


</style>