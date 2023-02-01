<template>
    <div class="row adminpanel-centered">
        <h3>Varaukset</h3>
    </div>
    <div class="row searchrow">
        <div class="col-8">
            <label for="searchbar" class="filterlabel">Hakusana:</label>
            <input class="form-control form-control-lg" v-model="input" name="searchbar" type="text" placeholder="Hae varauksista..." id="searchinput">
        </div>
        <div class="col-4">
            <label for="filterby" class="filterlabel">Hakukriteeri:</label>
            <select name="filterby" id="filterselect" class="form-control form-control-lg" v-model="filterselect">
                <option value="name">Varaajan nimi</option>
                <option value="location">Toimipiste</option>
                <option value="service">Palvelu</option>
            </select>
        </div>
    </div>
    <div class="container tablecontain">
        <table>
            <tr>
                <th id="datecol">Päivämäärä</th>
                <th id="timecol">Kellonaika</th>
                <th id="namecol">Varaajan nimi</th>
                <th id="servicecol">Palvelu</th>
                <th id="locationcol">Toimipiste</th>
                <th></th>
            </tr>
            <tr v-for="reservation in filteredArray">
                <td>{{ getPVM(reservation.t_start) }}</td>
                <td>{{ getTime(reservation.t_start, reservation.t_end) }}</td>
                <td>{{ reservation.customer.firstname }} {{ reservation.customer.lastname }}</td>
                <td>{{ reservation.service.name }}</td>
                <td>{{ reservation.location.name }}</td>
                <td>
                    <a :href="baseURL + '/timetables?location=' + reservation.location.id + '&service=' + reservation.service.id + '&offset=0&reservation_id=' + reservation.id" class="adminctrl edit btn"><font-awesome-icon icon="fa-regular fa-pen-to-square" /></a>
                    <button class="adminctrl delete btn" @click="rmrsrv(reservation.id)"><font-awesome-icon icon="fa-regular fa-trash-can" /></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="row adminpanel-centered">
        <a href="/admin/createreservation" class="addbutton"><font-awesome-icon icon="fa-solid fa-plus" /> Lisää uusi varaus</a>
        <button @click="rmexpired()" class="addbutton delete"><font-awesome-icon icon="fa-regular fa-trash-can" /> Poista vanhentuneet</button>
    </div>
    
</template>

<script>


    export default{
        props: [ 'reservations', 'locations', 'services', 'customers', 'token' ],
        data: function () {
            return {
                filterselect: 'name',
                input: '',
                filteredArray: '',
                allReservations: '',
                baseURL: window.location.protocol + '//' + window.location.hostname
            }
        },
        mounted() {
            console.log(this.customers);
            this.filteredArray = this.reservations;
            this.allReservations = this.reservations;
        },
        watch: {
            input(newValue, oldValue) {
                this.filteredArray = this.filteredList(this.filterselect);
                console.log(this.filteredArray);
            },
            allReservations(newArr, oldArr) {
                this.filteredArray = this.filteredList(this.filterselect);
                console.log("watch");
                console.log(this.filteredArray);
            }
        },
        methods: {
            getPVM(datetime) {
                let string_split = datetime.split(" ");
                let pvm_shitformat = string_split[0];
                let pvm_arr = pvm_shitformat.split("-");
                var pvm_final = pvm_arr[2].concat(".", pvm_arr[1], ".", pvm_arr[0]);
                return pvm_final;
            },
            getTime(start_datetime, end_datetime) {
                let string_split = start_datetime.split(" ");
                let time_shitformat = string_split[1];
                let time_arr = time_shitformat.split(":");
                var starttime_final = time_arr[0].concat(":", time_arr[1]);

                string_split = end_datetime.split(" ");
                time_shitformat = string_split[1];
                time_arr = time_shitformat.split(":");
                var endtime_final = time_arr[0].concat(":", time_arr[1]);

                var time_final = starttime_final.concat("-", endtime_final);
                return time_final;
            },
            filteredList(filterBy) {
                if(this.input){
                    switch (filterBy) {
                        case 'name':
                            return this.allReservations.filter(el => {
                                return el.customer.name.toLowerCase().includes(this.input.toLowerCase());
                            });
                            break;
                        case 'location':
                            return this.allReservations.filter(el => {
                                return el.location.name.toLowerCase().includes(this.input.toLowerCase());
                            });
                            break;
                        case 'service':
                            return this.allReservations.filter(el => {
                                return el.service.name.toLowerCase().includes(this.input.toLowerCase());
                            });
                            break;
                        default:
                            break;
                    }
                } else {
                    return this.allReservations;
                }
                
            },
            rmrsrv(id) {
                let data = {_token: this.token, rsrv_id: id};
                fetch("/admin/rmrsrv", {
                    method: "POST",
                    headers: {'Content-Type': 'application/json'}, 
                    body: JSON.stringify(data)
                }).then(res => {
                    var index = this.allReservations.map(allReservations => allReservations.id).indexOf(id);
                    this.allReservations.splice(index, 1);
                });
            },
            rmexpired() {
                fetch("/admin/rmexpired")
                    .then(res => res.json())
                    .then(res => {
                        console.log(res);
                        res.deleted.forEach(id => {
                            var index = this.allReservations.map(allReservations => allReservations.id).indexOf(id);
                            console.log(index);
                            this.allReservations.splice(index, 1);
                        });
                    })
            }
        }
    }
</script>