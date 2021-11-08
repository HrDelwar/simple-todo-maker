<template>
  <div>
    <h1>All todos</h1>
    <div class="todo_container">
      <div v-for="todo in todos" :class="[Number(todo.completed)?'completed':'']" class="todo_item"
           :key="todo.id">
        <input type="checkbox" :checked="Number(todo.completed)"/>
        <h4 class="todo_title">
          {{ todo.todo_name }}
        </h4>
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
            text: err.message,
            icon: 'error'
          })
        }
      })
    }

    return {
      todos
    }
  }
}
</script>

<style scoped>
h1{
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
</style>