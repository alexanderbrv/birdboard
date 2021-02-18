<template>
    <modal name="new-project" classes="p-8 bg-page rounded-lg" height="auto">
        <h1 class="font-normal mb-16 text-center text-2xl">Let's start sometnihg new</h1>

        <form @submit.prevent="submit()">
            <div class="flex">
                <div class="flex-1 mr-3">
                    <div class="mb-4">
                        <label for="title" class="text-sm block">Title</label>
                        <input
                            v-model="form.title"
                            type="text"
                            name="title"
                            id="title"
                            class="border p-2 text-xs block w-full rounded"
                            :class="errors.title ? 'border-error' : ''"
                        >

                        <span v-if="errors.title" v-text="errors.title[0]" class="text-error italic text-sm"></span>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="text-sm block">Description</label>
                        <textarea
                            v-model="form.description"
                            name="description"
                            id="description"
                            rows="7"
                            class="border p-2 text-xs block w-full rounded"
                        ></textarea>
                    </div>
                </div>

                <div class="flex-1">
                    <div class="mb-4">
                        <label class="text-sm block">Need some task?</label>

                        <input
                            v-for="task in form.tasks"
                            v-model="task.body"
                            type="text"
                            class="border p-2 mb-2 text-xs block w-full rounded"
                        >

                        <button type="button" class="text-xs" @click="addTask()">Add New Task</button>
                    </div>
                </div>
            </div>

            <footer class="flex justify-end">
                <button type="button" class="button is-outlined mr-4" @click="hide()">Cancel</button>
                <button class="button">Create Project</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    title: '',
                    description: '',
                    tasks: [
                        { body: '' }
                    ]
                },

                errors: {},
            }
        },

        methods: {
            show () {
                this.$modal.show('new-project');
            },
            hide () {
                this.$modal.hide('new-project');
            },
            addTask() {
                this.form.tasks.push({ body: '' });
            },
            submit() {
                axios.post('/projects', this.form)
                    .then(response => {
                        location = response.data.path;
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    })
            }
        }
    }
</script>
