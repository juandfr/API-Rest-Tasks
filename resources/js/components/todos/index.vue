<template>
    <div>
        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Task List</div>

                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="task in tasks" :key="task.id">
                                        <td>{{ task.id }}</td>
                                        <td>{{ task.title }}</td>
                                        <td>{{ task.description }}</td>
                                        <td>
                                            <button
                                                class="btn btn-danger"
                                                v-on:click="
                                                    destroyTask(task.id)
                                                "
                                            >
                                                X
                                            </button>

                                            <button
                                                class="btn btn-primary"
                                                v-on:click="showTask(task)"
                                            >
                                                S
                                            </button>

                                            <button
                                                class="btn btn-primary"
                                                v-on:click="edit(task)"
                                            >
                                                E
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5" v-if="task.id == null">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Create Task</div>
                        <div class="card-body">
                            <form @submit.prevent="storeTask()">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="task.title"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="task.description"
                                    />
                                </div>
                                <div class="form-group form-check">
                                    <input
                                        id="exampleCheck1"
                                        type="checkbox"
                                        class="form-check-input"
                                        v-model="task.finished"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="exampleCheck1"
                                        >Finished</label
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" v-if="task.id">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Update Task: {{ this.task.id }}
                        </div>
                        <div class="card-body">
                            <form @submit.prevent="updateTask()">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="task.title"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="task.description"
                                    />
                                </div>
                                <div class="form-group form-check">
                                    <input
                                        id="exampleCheck1"
                                        type="checkbox"
                                        class="form-check-input"
                                        v-model="task.finished"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="exampleCheck1"
                                        >Finished</label
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            task: {
                id: null,
                title: null,
                description: null,
                finished: false
            },
            tasks: []
        };
    },
    mounted() {
        this.getTasks();
    },

    methods: {
        storeTask() {
            axios
                .post("/api/tasks", {
                    title: this.task.title,
                    description: this.task.description,
                    finished: this.task.finished
                })
                .then(response => {
                    this.task.title = null;
                    this.task.description = null;
                    this.task.finished = null;

                    alert("sucesso");

                    this.getTasks();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        getTasks() {
            axios
                .get("/api/tasks")
                .then(response => {
                    this.tasks = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
                .then(() => {
                    // always executed
                });
        },

        showTask(task) {
            alert(task.title);
        },

        edit(task) {
            this.task.id = task.id;
            this.task.title = task.title;
            this.task.description = task.description;
            this.task.finished = task.finished;
        },

        updateTask() {
            axios
                .put(`/api/tasks/${this.task.id}`, {
                    title: this.task.title,
                    description: this.task.description,
                    finished: this.task.finished
                })
                .then(response => {
                    this.task.id = null;
                    this.task.title = null;
                    this.task.description = null;
                    this.task.finished = null;

                    alert("sucesso ao atualizar tarefa");

                    this.getTasks();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        destroyTask(id) {
            axios
                .delete(`/api/tasks/${id}`)
                .then(response => {
                    this.getTasks();
                })
                .catch(error => {
                    console.log(error);
                })
                .then(() => {
                    // always executed
                });
        }
    }
};
</script>
