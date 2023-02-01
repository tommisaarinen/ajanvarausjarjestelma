<template>
    <div class="row adminpanel-centered">
        <h3>Asiakkaat</h3>
    </div>
    <div class="row searchrow">
        <input class="form-control form-control-lg" v-model="input" name="searchbar" type="text" placeholder="Hae asiakastileistä..." id="searchinput">    
    </div>
    <div class="container tablecontain">
        <table>
            <tr>
                <th>Nimi</th>
                <th>Sähköposti</th>
                <th>Puhelinnumero</th>
                <th>Tunnist. koodi</th>
                <th>Luotu</th>
                <th></th>
            </tr>
            <tr v-for="customer in filteredArray">
                <td>{{ customer.name }}</td>
                <td>{{ customer.email }}</td>
                <td>{{ customer.phone }}</td>
                <td>{{ customer.authcode }}</td>
                <td>{{ customer.created_at }} (UTC)</td>
                <td>
                    <a :href="'/admin/editcustomer?cstmr_id=' + customer.id" class="adminctrl edit btn"><font-awesome-icon icon="fa-regular fa-pen-to-square" /></a>
                    <button type="submit" class="adminctrl delete btn" @click="rmcustomer(customer.id)"><font-awesome-icon icon="fa-regular fa-trash-can" /></button>
                </td>
            </tr>
        </table>
    </div>
    
</template>

<script>

    export default{
        props: [ 'customers', 'token' ],
        data: function () {
            return {
                filterselect: 'name',
                input: '',
                filteredArray: '',
                allCustomers: ''
            }
        },
        mounted() {
            console.log(this.customers);
            this.filteredArray = this.customers;
            this.allCustomers = this.customers;
        },
        watch: {
            input(newValue, oldValue) {
                this.filteredArray = this.filteredList();
            },
            allCustomers(newArr, oldArr) {
                this.filteredArray = this.filteredList();
            }
        },
        methods: {
            filteredList() {
                if(this.input){
                    return this.allCustomers.filter(el => {
                                return el.name.toLowerCase().includes(this.input.toLowerCase());
                            });
                } else {
                    return this.allCustomers;
                }
            },
            rmcustomer(id) {
                let data = {_token: this.token, customer_id: id};
                fetch("/admin/rmcustomer", {
                    method: "POST",
                    headers: {'Content-Type': 'application/json'}, 
                    body: JSON.stringify(data)
                }).then(res => {
                    var index = this.allCustomers.map(allCustomers => allCustomers.id).indexOf(id);
                    this.allCustomers.splice(index, 1);
                });
            }
        }
    }
</script>