import Vue from "vue";
import axios from "axios";
import VueAxios from "vue-axios";

import {API_URL} from "../common/config";

const ApiService = {
    init(){
        axios.interceptors.response.use(undefined, err => {
            let res = err.response;
            if (res.status >= 500) {
                return new Promise((resolve, reject) => {
                    let errMessage = 'Error occur:  Some server error intercepted due your request.';
                    Vue.$notify.error(errMessage, {mode: 'html'});
                    this.responseErrors.push(errMessage);
                    reject(err);
                });
            }
        });
        Vue.use(VueAxios, axios);
        Vue.axios.defaults.baseURL = API_URL;
    },
    setHeader() {
        Vue.axios.defaults.headers.common = {};
    },
    get(resource, slug = "") {
        return Vue.axios.get(`${resource}/${slug}`).catch(error => {
            throw new Error(`[RWV] ApiService ${error}`);
        });
    },
    post(resource, params) {
        return Vue.axios.post(`${resource}`, params);
    },
    put(resource, params) {
        return Vue.axios.put(`${resource}`, params);
    },
};

export default ApiService;