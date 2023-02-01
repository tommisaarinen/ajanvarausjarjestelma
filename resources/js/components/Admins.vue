<template>
    <div class="row adminpanel-centered">
        <h3>Valvojat</h3>
    </div>

    <div class="container tablecontain">
        <table>
            <tr>
                <th>Käyttäjänimi</th>
                <th>Luotu</th>
                <th>Päivitetty</th>
                <th></th>
            </tr>
            <tr v-for="admin in allAdmins">
                <td>{{ admin.username }}</td>
                <td>{{ formatTime(admin.created_at) }} (UTC)</td>
                <td>{{ formatTime(admin.updated_at) }} (UTC)</td>
                <td>
                    <a :href="'/admin/editadmin?admin_id=' + admin.id" class="adminctrl edit btn"><font-awesome-icon icon="fa-regular fa-pen-to-square" /></a>
                    <button type="submit" class="adminctrl delete btn" @click="rmadmin(admin.id)"><font-awesome-icon icon="fa-regular fa-trash-can" /></button>
                </td>
            </tr>
        </table>
    </div>
    <div class="row adminpanel-centered">
        <a href="/admin/createadmin" class="addbutton"><font-awesome-icon icon="fa-solid fa-user-plus" /> Luo uusi valvojatili</a>
    </div>

</template>

<script>
    export default{
        props: [ 'admins', 'token' ],
        data: function() {
            return {
                allAdmins: ''
            }
        },
        mounted() {
            this.allAdmins = this.admins;
        },
        watch: {
            allAdmins(newArr, oldArr) {
                this.allAdmins = newArr;
            }
        },
        methods: {
            formatTime(timestamp) {
                let blocks = timestamp.split("T");
                let date = blocks[0];
                blocks = blocks[1].split(".");
                let time = blocks[0];
                var formatted = date.concat(" ", time);
                return formatted;
            },
            rmadmin(id) {
                let data = {_token: this.token, admin_id: id};
                fetch("/admin/rmadmin", {
                    method: "POST",
                    headers: {'Content-Type': 'application/json'}, 
                    body: JSON.stringify(data)
                }).then(res => {
                    var index = this.allAdmins.map(allAdmins => allAdmins.id).indexOf(id);
                    this.allAdmins.splice(index, 1);
                });
            }
        }
    }
</script>