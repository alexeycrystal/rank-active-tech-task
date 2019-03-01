<template>
    <div class="demo-page-wrap">
        <div>
            <table class="table table-striped text-left">
                <tbody>
                <tr>
                    <td colspan="1">

                        <form class="form-horizontal" v-on:submit.prevent="submitTaskForm()">
                            <fieldset>
                                <div class="form-group error-block"
                                     v-show="responseErrors.length > 0">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-8">
                                        Errors occurred during the Task-creation request:
                                        <br/>
                                        <ul id="responseErrors">
                                            <li v-for="item in responseErrors">
                                                {{ item }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select country:</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <cool-select
                                                name="selectedCountry"
                                                v-validate="'required'"
                                                v-model="selectedCountry"
                                                :items="items"
                                                item-value="name"
                                                item-text="name"
                                                v-on:select="getSearchEnginesByCountry(country)">
                                            <template
                                                    slot="item"
                                                    slot-scope="{ item: country }">
                                                <div style="display: flex; align-items: center;">
                                                    <img :src="getFlag(country.code)"
                                                         class="country-flag" alt="">
                                                    <div class="country-name">
                                                        <b>{{ country.name }}</b>
                                                    </div>
                                                </div>
                                            </template>
                                            <template
                                                    slot="selection"
                                                    slot-scope="{ item: country }">
                                                <img :src="getFlag(country.code)"
                                                     class="country-flag">
                                                <div>
                                                    <b>{{ country.name }}</b>
                                                </div>
                                            </template>
                                        </cool-select>
                                        <span v-show="errors.has('selectedCountry')"
                                              class="error-block">
                                                * {{ errors.first('selectedCountry') }}
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Select Region:</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <region-select name="region"
                                                       v-model="region"
                                                       v-validate="'required'"
                                                       :country="country"
                                                       :region="region"
                                                        class="form-control"
                                                       regionName="true"/>
                                        <span v-show="errors.has('region')"
                                              class="error-block">
                                                * {{ errors.first('region') }}
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Enter city / district title:
                                    </label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-king"></i>
                                            </span>
                                            <input id="regionUserInput"
                                                   name="regionUserInput"
                                                   v-model="city"
                                                   v-validate="'required'"
                                                   placeholder="Enter region for specific computing"
                                                   class="form-control"
                                                   type="text">
                                            <span v-show="errors.has('regionUserInput')"
                                                  class="error-block">
                                                * {{ errors.first('regionUserInput') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Search engine:
                                    </label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-search">
                                                </i>
                                            </span>
                                            <v-select name="selectedEngine"
                                                    label="se_full_title"
                                                      v-model="selectedEngine"
                                                      v-validate="'required'"
                                                      :options="searchEngineByCurrentCountry">
                                            </v-select>
                                            <span v-show="errors.has('selectedEngine')"
                                                  class="error-block">
                                                * {{ errors.first('selectedEngine') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hidden">
                                    <label class="col-md-3 control-label">
                                        Search engine language:
                                    </label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-search">
                                                </i>
                                            </span>
                                            <v-select label="se_language"
                                                      v-model="selectedEngine"
                                                      v-validate="'required'"
                                                      :options="searchEngineByCurrentCountry">
                                            </v-select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Website address:
                                    </label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-object-align-top">
                                                </i>
                                            </span>
                                            <input id="website"
                                                   name="website"
                                                   v-model="website"
                                                   v-validate="'required'"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Enter your web site">
                                            <span v-show="errors.has('website')"
                                                  class="error-block">
                                                * {{ errors.first('website') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">
                                        Enter specific keyword:
                                    </label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-tag">
                                                </i>
                                            </span>
                                            <input id="keyword"
                                                   name="keyword"
                                                   v-model="keyword"
                                                   v-validate="'required'"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Choose the keyword">
                                            <span v-show="errors.has('keyword')"
                                                  class="error-block">
                                                * {{ errors.first('keyword') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Set the identifier:</label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-star">
                                                </i>
                                            </span>
                                            <input id="taskIdentifier"
                                                   name="taskIdentifier"
                                                   v-model="taskIdentifier"
                                                   v-validate="'required'"
                                                   class="form-control"
                                                   type="text"
                                                   placeholder="Choose the specific name for the task">
                                            <span v-show="errors.has('taskIdentifier')"
                                                  class="error-block">
                                                * {{ errors.first('taskIdentifier') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <label class="col-md-3 control-label">
                                    </label>
                                    <div class="col-md-8 inputGroupContainer">
                                        <button :disabled="createButtonDisabled"
                                                type="submit"
                                                class="btn btn-primary">
                                            Create new task
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import 'vue-country-region-select'

    import countries from '../data/countriesTotal'
    import {CoolSelect} from 'vue-cool-select'

    import ApiService from '../api/api.service'

    export default {
        components: {
            CoolSelect
        },
        mounted(){
            this.getSearchEnginesByCountry(this.country);
        },
        data: () => ({
            responseErrors: [],
            items: countries.data,
            searchEngineByCurrentCountry: [],

            selectedEngine: '',
            selectedCountry: 'United States',

            taskIdentifier: '',
            country: '',
            region: '',
            city: '',
            website: '',
            keyword: '',

            createButtonDisabled: false,
        }),
        methods: {
            submitTaskForm() {
                this.$validator.validateAll().then((result) => {
                    if (result) this.createNewTask();
                });
            },
            createNewTask() {
                this.createButtonDisabled = true;
                ApiService.post('/api/task', {
                    "task":{
                        "identifier": this.taskIdentifier,
                        "site": this.website,
                        "se_name": this.selectedEngine.se_name,
                        "se_language":this.selectedEngine.se_language,
                        "loc_name_canonical":
                            this.city + ',' +
                            this.region + ',' +
                            this.selectedCountry,
                        "key": this.keyword
                    }
                }).then(({data}) => {
                    if (data.error) {
                        let errorTemplate = data.error[this.taskIdentifier].message;
                        this.responseErrors.push(errorTemplate);
                        this.$notify.error(
                            `<b>Error occures: </b> {this.errorTemplate}`,
                            {mode: 'html'}
                        )
                    } else {
                        this.$notify.success(
                            'Task successfully created! You can proceed to task list.'
                        );
                    }
                }).finally(() => {
                    this.createButtonDisabled = false;
                });
            },
            getFlag(countryCode) {
                this.country = countryCode;
                try {
                    return require('../data/flags/' + countryCode.toLowerCase() + '.png')
                } catch (e) {
                    return require('../data/flags/undefined.svg')
                }
            },
            setCountry(countryCode) {
                this.country = countryCode;
            },
            getSearchEnginesByCountry(country){
                ApiService.get('/api/searchEngines', country)
                    .then(({data}) => {
                        this.searchEngineByCurrentCountry =
                            data.models && data.models.length > 0 ? data.models : [];
                    });
            },
        }
    }
</script>
<style>
    .country-flag {
        max-width: 30px;
        margin-right: 10px;
        border: 1px solid #eaecf0;
    }
    .country-name {
        font-size: 15px;
    }
    .v-select .dropdown-toggle .clear { visibility: hidden; }
    input[type="text"]{
        padding: 20px 10px;
        line-height: 20px;
        width:197px;
        font-size: 14px;
    }
    select{
        width:345px;
        border:1px solid #ccc;
        padding: 10px 10px;
        font-size: 14px;
    }

    .input-group-addon {
        position: relative
    }

    .error-block {
        color: red;
    }
</style>
