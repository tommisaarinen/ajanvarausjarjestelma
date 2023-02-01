<template>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light admin-nav">
                <ul class="navbar-nav">
                    <li class="nav-item" v-for="tab in tabs" :class="{'active': activeTabName == tab.name}">
                        <a class="nav-link" href="#" @click.prevent="setActiveTabName(tab.name)">
                            {{ tab.displayName }}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row approw">
            <div class="container appwrap">
                <div v-if="activeTabName == 'home'">
                    <home></home>
                </div>
                <div v-if="activeTabName == 'reservations'">
                    <reservations :reservations="reservations" :locations="locations" :services="services" :customers="customers" :token="token"></reservations>
                </div>
                <div v-if="activeTabName == 'locations'">
                    <locations :locations="locations" :reservations="reservations" :token="token"></locations>
                </div>
                <div v-if="activeTabName == 'services'">
                    <services :services="services" :token="token"></services>
                </div>
                <div v-if="activeTabName == 'customers'">
                    <customers :customers="customers" :token="token"></customers>
                </div>
                <div v-if="activeTabName == 'admins'">
                    <admins :admins="admins" :token="token"></admins>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Home from './Home.vue'
    import Reservations from './Reservations.vue'
    import Admins from './Admins.vue'
    import Customers from './Customers.vue'
    import Locations from './Locations.vue'
    import Services from './Services.vue'

    export default{
        components: {
            Home,
            Reservations,
            Admins,
            Customers,
            Locations,
            Services
            },
        props: [
            'reservations', 'customers', 'locations', 'admins', 'services', 'directTo', 'token'
        ],
        data() {
            return {
            // List here all available tabs
            tabs: [
                {
                    name: 'home',
                    displayName: 'Koti',
                },
                {
                    name: 'reservations',
                    displayName: 'Varaukset',
                },
                {
                    name: 'locations',
                    displayName: 'Toimipisteet',
                },
                {
                    name: 'services',
                    displayName: 'Palvelut',
                },
                {
                    name: 'customers',
                    displayName: 'Asiakkaat',
                },
                {
                    name: 'admins',
                    displayName: 'Valvojat',
                }
            ],
            activeTabName: 'home'
            };
        },
        mounted() {
            // The currently active tab, init as the 1st item in the tabs array
            this.activeTabName = this.tabs[0].name;
            this.customers.map(customer => {
                customer.name = customer.firstname + ' ' + customer.lastname;
            })
            this.reservations.map(reservation => {
                reservation.location = this.locations.find(location => location.id == reservation.location_id);
                const customerObject = this.customers.find(customer => customer.id == reservation.customer_id);
                reservation.customer = customerObject;
                reservation.service = this.services.find(service => service.id == reservation.service_id);
                
            });
            console.log(this.reservations);
        },
        methods: {
            setActiveTabName(name) {
            this.activeTabName = name;
            },
            displayContents(name) {
                return this.activeTabName === name;
            },
        },
    }
</script>