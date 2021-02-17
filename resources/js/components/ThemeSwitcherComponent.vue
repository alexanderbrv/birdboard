<template>
    <div class="flex items-center mr-5">
        <div v-for="(color, theme) in themes"
             class="rounded-full w-4 h-4 border mr-2"
             :class="{ 'border-accent': selectedTheme == theme }"
             :style="{ backgroundColor: color}"
             @click="selectedTheme = theme"
        ></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                themes: {
                    'theme-light': '#fff',
                    'theme-dark': '#222',
                },
                selectedTheme: 'theme-light'
            }
        },

        created() {
            this.selectedTheme = localStorage.getItem('theme') || this.selectedTheme;
        },

        watch: {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);

                localStorage.setItem('theme', this.selectedTheme);
            }
        }
    }
</script>
