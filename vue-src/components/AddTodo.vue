<template>
  <div class="add-todo">
    <div class="">
      <div class="">
        <h1>Add New Todo</h1>
      </div>

      <div class="">
        <form>
          <input type="text" id="todo_name" placeholder="Todo..." v-model="todo_name"/>
          <button class="add_todo_button" type="submit" @click.prevent="addTodo">add todo</button>
        </form>
      </div>
    </div>
  </div>

</template>

<script>

import {ref, inject} from "vue";

export default {
  name: "AddTodo",
  props: ['todos'],
  setup(props) {
    let todo_name = ref('');
    const Swal = inject('$swal')

    function addTodo() {
      const data = {
        action: 'wpstm_create_todo',
        todo_name: todo_name.value,
        nonce: ajax_object.nonce
      }
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data,
        beforeSend() {
        },
        success(res) {
          if (res.status) {
            Swal.fire({
              text: res.message,
              icon: 'success',
              toast: true,
              timer: 2000,
              position: 'bottom-end',
              showConfirmButton: false,
            })
            props.todos.value = props.todos.unshift({
              todo_name: todo_name.value,
              id: res.id,
            })
            todo_name.value = ''
          } else {
            Swal.fire({
              title: 'Error!',
              text: res.message,
              icon: 'error'
            })
          }
        },
        error(req, _, err) {
          Swal.fire({
            title: 'Error!',
            text: err,
            icon: 'error'
          })
        }
      })
    }

    return {
      todo_name,
      addTodo
    }
  },
}
</script>

<style scoped>
h1 {
  color: gray;
  font-size: 30px;
  text-align: center;
  text-transform: capitalize;
}

input {
  padding: 2px 4px;
}

.add_todo_button {
  border: 0;
  background: goldenrod;
  display: inline-block;
  color: white;
  padding: 7px 15px;
  font-size: 16px;
  text-transform: capitalize;
  border-radius: 0 5px 5px 0;
}
</style>