<template>
  <div class="new-todo-form flex column">
    <tailwind-input type="text" v-model="todo_value" placeholder="Add New Todo" @submit="createTodo"/>
    <elevated-button class="ml-1" type="button" @click="createTodo">
       <svgicon icon="plus" width="22" height="18" color="blue"></svgicon>
    </elevated-button>
  </div>
</template>
<script>
import TailwindInput from "@/components/TailwindInput";
import ElevatedButton from "@/components/ElevatedButton";
import '@/compiled-icons/plus';

export default {
  components: { TailwindInput, ElevatedButton },
  data() {
    return { todo_value: "" };
  },
  methods: {
    createTodo: function() {
      this.$emit("submit", this.todo_value);
      this.todo_value = "";
    }
  }
};
</script>
