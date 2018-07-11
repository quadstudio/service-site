
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
let registerFormExists = document.getElementById("register-form");
if (registerFormExists !== null) {

    const rf = new Vue({
        el: '#register-form',
        data: {
            countries: [],
            regions: [],
            is_refresh: false,
            selected: ''
        },
        props: [
            'old', 'regionId'
        ],
        mounted(){
            this.getCountries();
        },
        methods: { //
            getCountries: function () {
                this.is_refresh = true;

                axios
                    .get("/api/countries")
                    .then((response) => {
                        this.countries = response.data.data;
                        this.is_refresh = false;
                    })
                    .catch((error) => {
                        this.status = 'Error:' + error;
                    });
            },
            getRegions: function (country_id) {
                this.is_refresh = true;

                axios
                    .get("/api/regions/" + country_id)
                    .then((response) => {
                        this.regions = response.data.data;
                        this.is_refresh = false;
                    })
                    .catch((error) => {
                        this.status = 'Error:' + error;
                    });
            },
            onSelectCountry: function (e) {
                let region_id = e.target.value;
                //let region_id = e.target.getAttribute('region-id');
                this.regions = region_id !== "" ? this.getRegions(region_id) : [];
                console.log(e.target.value);
                console.log();
            }
        }
    });
}

//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });
