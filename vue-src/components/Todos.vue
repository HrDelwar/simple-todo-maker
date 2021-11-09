<template>
  <div>
    <h1>All todos</h1>
    <div class="todo_container">
      <div v-for="{completed, id, todo_name} in todos" :class="[Number(completed)?'completed':'']"
           @dblclick="changeTodoStatus(id)" class="todo_item"
           title="Double click for change status."
           :key="id">
        <input type="checkbox" @change="changeTodoStatus(id)" :checked="Number(completed)"/>
        <h4 class="todo_title no_select">
          {{ todo_name }}
        </h4>
        <button class="todo_delete_btn" @click="deleteTodo(id)">
          <unicon name="trash-alt" fill="red"></unicon>
        </button>
      </div>
    </div>

  </div>
</template>

<script>
import {onMounted, inject, ref} from 'vue'
import {useRouter} from 'vue-router'

export default {
  name: "Todos",
  setup() {
    const todos = ref([])
    const Swal = inject('$swal')
    const router = useRouter()
    onMounted(() => {
      fetchAllTodo()
    })

    function fetchAllTodo() {
      $.ajax({
        url: ajaxurl,
        type: 'GET',
        data: {
          action: 'wpstm_get_all_todo',
          nonce: ajax_object.nonce
        },
        beforeSend() {
        },
        success(res) {
          if (res.status) {
            todos.value = res.todos
          } else {
            Swal.fire({
              title: 'Info!',
              text: res.message,
              icon: 'info',
              showDenyButton: true,
              confirmButtonText: 'Add Todo',
              denyButtonText: `Stay Here`,
            }).then((result) => {
              if (result.isConfirmed) {
                router.push({name: 'AddTodo'})
              }
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

    function changeTodoStatus(id) {
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          id: id,
          action: 'wpstm_change_todo_status',
          nonce: ajax_object.nonce
        },
        beforeSend() {
        },
        success(res) {
          if (res.status) {
            const todo = todos.value.find(todo => todo.id === id)
            todo.completed = res.completed;
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

    function deleteTodo(id) {

      Swal.fire({
        title: 'Info!',
        text: 'Sure you want to delete this?',
        icon: 'info',
        showDenyButton: true,
        confirmButtonText: 'Delete',
        denyButtonText: `Cancel`,
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
              id,
              action: 'wpstm_delete_todo',
              nonce: ajax_object.nonce
            },
            beforeSend() {
            },
            success(res) {
              if (res.status) {
                Swal.fire({
                  title: 'Success!',
                  text: res.message,
                  icon: 'success',
                  position: 'center',
                  confirmButton: false,
                  timer: 1500
                })
                todos.value = todos.value.filter(todo => todo.id !== id);
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
      })
    }

    return {
      todos,
      changeTodoStatus,
      deleteTodo
    }
  }
}
</script>

<style scoped>
h1 {
  color: gray;
  font-size: 30px;
  text-align: center;
  text-transform: capitalize;
}

.todo_container {
  display: flex;
  flex-wrap: wrap;
}

.todo_item {
  min-width: 200px;
  background: goldenrod;
  margin: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 8px;
  border-radius: 4px;
}

.todo_title:first-letter {
  text-transform: capitalize;
}

.todo_item.completed {
  background: #1c7430;
  color: white;
}

.todo_item:hover .todo_delete_btn {
  display: block;
}

.no_select {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

}

.todo_delete_btn {
  background: white;
  border: 0;
  border-radius: 4px;
  color: red;
  display: none;
  cursor: pointer;
}
</style>