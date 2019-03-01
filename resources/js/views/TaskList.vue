<template>
    <div>
        <h3 class="vue-title">Tasks list:
            <br/>
            <button :disabled="refreshButtonDisabled"
                    class="btn btn-primary refresh-button"
                    type="button"
                    v-on:click="refreshResults()">
                Refresh results</button>
        </h3>
            <v-client-table :columns="columns"
                            :data="data"
                            :options="options" ref="tasksTable">
                <a slot="uri" slot-scope="props" target="_blank"
                   v-on:click="viewTaskResult(props.row.task_id)"
                   :href="props.row.uri"
                   class="glyphicon glyphicon-eye-open"></a>
            </v-client-table>
        <modal name="view-task-result"
               @before-close="clearResults()"
               height="auto"
               :adaptive="true"
               :resizable="true"
               :scrollable="true" width="50%">
            <div slot="top-right">
                <button @click="$modal.hide('view-task-result')">
                    ❌
                </button>
            </div>
            <table class="table table-striped">
                <tbody>
                <tr v-for="(value, key) in taskResultEntry">
                    <th scope="row">{{ key }}:</th>
                    <td>{{ value }}</td>
                </tr>
                </tbody>
            </table>
        </modal>
    </div>
</template>
<script>
    import ApiService from '../api/api.service'

    export default {
        data() {
            return {
                columns: [
                    'uri','task_id', 'created_at','post_id', 'post_key',
                    'post_site', 'task_id', 'se_id', 'loc_id', 'key_id',
                ],
                data: [],
                options: {
                    filterable: false,
                    sortable: [
                        'status', 'task_id','post_id', 'post_key',
                        'post_site', 'task_id', 'se_id', 'loc_id', 'key_id',
                    ],
                    headings: {
                        uri: 'Show result:'
                    },
                },
                taskResultEntry: {},
                refreshButtonDisabled: false,
            }
        },
        mounted(){
            this.loadTaskList();
        },
        methods: {
            loadTaskList(){
                ApiService.get('/api/tasks')
                    .then(({data}) => {
                        this.data = data.data;
                    });
            },
            refreshResults(){
                this.refreshButtonDisabled = true;
                ApiService.put('/api/updateResults').then(({data}) => {
                    this.loadTaskList();
                    this.$notify.success(
                        'All tasks result data were refreshed.'
                    );
                }).finally(()=> {
                    this.refreshButtonDisabled = false;
                });
            },
            viewTaskResult(taskId){
                this.taskResultEntry = [];
                ApiService.get('/api/task/' + taskId).then(({data}) => {
                    if (data.error) {
                        let errorTemplate = data.error[this.taskIdentifier].message;
                        this.responseErrors.push(errorTemplate);
                        this.$notify.error(
                            `<b>Error occures: </b>]`,
                            {mode: 'html'}
                        )
                    } else {
                        if(data.data.results){
                            this.taskResultEntry = data.data.results;
                            this.showResultsModal();
                        } else {
                            this.$notify.error(
                                'Result for this task is empty. Try to update the results.'
                            )
                        }
                    }
                })
            },
            showResultsModal () {
                this.$modal.show('view-task-result');
            },
            clearResults(){
                this.taskResultEntry = {};
            }
        }
    }
</script>
<style>
    .vue-title {
        text-align: center;
        margin: 10px;
    }
    .refresh-button {
        margin: 20px;
    }
    .glyphicon.glyphicon-eye-open {
        width: 16px;
        display: block;
        margin: 0 auto;
    }
    th:nth-child(3) {
        text-align: center;
    }
    table {
        table-layout: auto;
        border-collapse: collapse;
        width: 100%;
    }
    table td {
        border: 1px solid #ccc;
    }
    table .absorbing-column {
        width: 100%;
    }
</style>