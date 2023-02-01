<template>
    <div class="row adminpanel-centered">
        <h3>Palvelut</h3>
    </div>

    <div class="container tablecontain">
        <table>
            <tr>
                <th>Nimi</th>
                <th>Saatavilla</th>
                <th>Arvioitu kesto (h)</th>
                <th>Peruutus</th>
                <th></th>
            </tr>
            <tr v-for="service in allServices">
                <td>{{ service.name }}</td>
                <td>{{ booleanTranslate(service.available) }}</td>
                <td>{{ service.t_est }}</td>
                <td>{{ booleanTranslate(service.cancellable) }}</td>
                <td>
                    <a :href="'/admin/editservice?srvc_id=' +  service.id" class="adminctrl edit btn"><font-awesome-icon icon="fa-regular fa-pen-to-square" /></a> 
                    <button type="submit" class="adminctrl delete btn" @click="rmsrvc(service.id)"><font-awesome-icon icon="fa-regular fa-trash-can" /></button>
                </td>
            </tr>
        </table>
    </div>

    <div class="row adminpanel-centered">
        <a href="/admin/createservice" class="addbutton"><font-awesome-icon icon="fa-solid fa-plus" /> Lisää palvelu</a>
    </div>

</template>

<script>
    export default{
        props: [ 'services', 'token' ],
        data: function() {
            return {
                allServices: ''
            }
        },
        mounted() {
            this.allServices = this.services;
        },
        watch: {
            allServices(newArr, oldArr) {
                this.allServices = newArr;
            }
        },
        methods: {
            booleanTranslate(value) {
                if(value == 1) {
                    return "Kyllä";
                } else {
                    return "Ei";
                }
            },
            rmsrvc(id) {
                let data = {_token: this.token, service_id: id};
                fetch("/admin/rmsrvc", {
                    method: "POST",
                    headers: {'Content-Type': 'application/json'}, 
                    body: JSON.stringify(data)
                }).then(res => {
                    var index = this.allServices.map(allServices => allServices.id).indexOf(id);
                    this.allServices.splice(index, 1);
                });
            }
        }
    }
</script>