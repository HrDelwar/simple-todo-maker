<template>
  <div class="">
    <h1>Short Code</h1>

    <div class="">
      <h2>Add Todo Section</h2>

      <div class="shortcode-wraper">
        <p class="short-code" id="add_todo_shortcode" title="Click for copy code"
           @click="copyShotCode('#add_todo_shortcode')">
          [wpstm-add-todo title="Add Todo"]
        </p>
        <button class="copy-btn" @click="copyShotCode('#add_todo_shortcode')">copy</button>
      </div>
    </div>

    <div class="">
      <h2>All Todos View</h2>
      <div class="shortcode-wraper">
        <p class="short-code" id="todos_view_shortcode" title="Click for copy code"
           @click="copyShotCode('#todos_view_shortcode')">
          [wpstm-all-todo-view title="Todos"]
        </p>
        <button class="copy-btn" title="copy shortcode" @click="copyShotCode('#todos_view_shortcode')">copy</button>
      </div>
    </div>


  </div>
</template>

<script>
import {inject} from "vue";

export default {
  name: "Shortcode",
  setup() {
    const Swal = inject('$swal')

    function copyShotCode(element) {
      let $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      Swal.fire({
        title: 'copied!',
        text: $(element).text(),
        timer: 1800,
        icon: 'success',
        showConfirmButton: false,
      })
    }

    return {
      copyShotCode
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

.short-code.copied {
  background: #2ab2c8;
  color: black;
}

.shortcode-wraper {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background: #dbd4d4;
  border-radius: 5px;
  color: #2ab2c8;
  box-shadow: inset 1px 1px 8px #7e8286;
}

.short-code {
  padding: 6px;
  border-radius: 4px;
  box-shadow: 0px 0px 1px;
}

.copy-btn {
  background: goldenrod;
  border: 0;
  border-radius: 4px;
  padding: 7px 10px;
  font-size: 16px;
  text-transform: uppercase;
  max-height: 33px;
  color: white;
  box-shadow: 0 0 2px #dddfd6;
  cursor: pointer;
}

</style>