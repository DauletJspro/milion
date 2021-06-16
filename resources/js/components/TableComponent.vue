<template>
    <div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Имя Фамилия (Студента)</th>
                <th v-for="date in dates">{{ date }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(attendance, student_id) in attendances">
                <th scope="row">{{ students[student_id] }}</th>
                <th v-for="(item,key) in attendance">
                    <div class="icheck-success d-inline">
                        <input v-model="attendances[student_id][key]" type="checkbox"
                               :id="'checkBox' +':' +student_id +':'+ key">
                        <label :for="'checkBox' +':' +student_id +':'+ key">
                        </label>
                    </div>
                </th>
            </tr>
            </tbody>
        </table>
        <button v-on:click="update_table" class="btn btn-success">
            Сохранить
        </button>
    </div>
</template>
<script>
export default {
    name: "TableComponent",
    data() {
        return {
            dates: [],
            attendances: [],
            students: [],
            group_id: this.$route.query.group_id,
        }
    },
    created() {
        this.axios
            .get('/api/attendance/dates/?group_id=' + this.group_id)
            .then(response => {
                this.dates = response.data.data;
            });
        this.axios
            .get('/api/attendance/notes?group_id=' + this.group_id)
            .then(response => {
                this.attendances = response.data.data;
            });
        this.axios
            .get('/api/group/students?group_id=' + this.group_id)
            .then(response => {
                this.students = response.data.data;
            });
    },
    methods: {
        update_table(group_id) {
            this.axios
                .post('/api/attendance/update', {'attendances': this.attendances, 'group_id': this.group_id})
                .then(alert('Вы успешно сохранили!'))
                .catch(err => alert(err));
        }
    }
}
</script>

<style scoped>
.notifyjs-happyblue-superblue {
    color: white;
    background-color: blue;
}
</style>
