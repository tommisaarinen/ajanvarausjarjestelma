<template>
    <div class="row adminpanel-centered">
        <h3>Toimipisteet</h3>
    </div>

    <div class="container tablecontain">
        <table>
            <tr>
                <th>Nimi</th>
                <th>Osoite</th>
                <th>Postinumero</th>
                <th>Kaupunki</th>
                <th></th>
            </tr>
            <tr v-for="location in allLocations">
                <td>{{ location.name }}</td>
                <td>{{ location.address }}</td>
                <td>{{ location.zip }}</td>
                <td>{{ location.city }}</td>
                <td>
                    <a :href="'/admin/editlocation?lct_id=' +  location.id" class="adminctrl edit btn"><font-awesome-icon icon="fa-regular fa-pen-to-square" /></a>                      
                    <button type="submit" class="adminctrl delete btn" @click="rmlocation(location.id)"><font-awesome-icon icon="fa-regular fa-trash-can" /></button>
                </td>
            </tr>
        </table>
    </div>
    <div class="row adminpanel-centered">
        <a href="/admin/createlocation" class="addbutton"><font-awesome-icon icon="fa-solid fa-plus" /> Lisää uusi toimipiste</a>
    </div>

</template>

<script>
    export default{
        props: [ 'locations', 'reservations', 'token' ],
        data: function () {
            return {
               allLocations: '' 
            }
        },
        mounted() {
            this.allLocations = this.locations;
        },
        watch: {
            allLocations(newArr, oldArr) {
                this.allLocations = newArr;
            }
        },
        methods: {
            rmlocation(id) {
                let data = {_token: this.token, location_id: id};
                fetch("/admin/rmlocation", {
                    method: "POST",
                    headers: {'Content-Type': 'application/json'}, 
                    body: JSON.stringify(data)
                }).then(res => {
                    var index = this.allLocations.map(allLocations => allLocations.id).indexOf(id);
                    this.allLocations.splice(index, 1);
                });
            }
        }
    }
</script>