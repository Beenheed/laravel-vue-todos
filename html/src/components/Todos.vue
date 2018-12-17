<template>
  <div class="container">
    <div class="card">
     
      <div class="card-header">
        <h1>Todo List</h1>
      </div>

      <div class="card-body">
        <div v-if="todos.length > 0" class="list-group">
          <div class="list-group-item"
            v-for="todo in todos"
            :class="todoStatus(todo)"
            :disabled="todo.done"
          >
            <div class="row">
              <div class="col-10">
                <p><strong>{{ todo.title }}</strong> - until: {{ todo.due_date }}</p>
                <span class="small">{{ todo.description }}</span>
              </div>
              <div class="col-1"><input type="checkbox" value="1" v-model="todo.done" @change="updateTodo(todo)"></div>
              <div class="col-1"><button class="btn btn-sm btn-danger" @click="deleteTodo(todo)"><i class="fas fa-trash"></i></button></div>
            </div>
          </div>
        </div>
        <div v-else>
          <p>no todos yet</p>
        </div>
      </div>
      <div class="card-footer text-center">
        <button class="button btn-primary" @click="showModal = true"><i class="fas fa-plus"></i> new todo</button>
      </div>
    </div>

    <b-modal id="todoModal" v-model="showModal" hide-footer size="lg" @hide="cancelModal()" :title="'add new Todo'">
        <div class="row">
          <div class="col-12">
            <h3>add new Todo</h3>
            <div class="row">
              <div class="form-group col-6">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" v-model="newTodo.title" class="form-control" required="true">
              </div>
              <div class="form-group col-6">
                <label for="due_date">Due to:</label>
                <input type="date" name="due_date" id="due_date" v-model="newTodo.due_date" class="form-control" required="true">
              </div>
              <div class="form-group col-12">
                <label for="description">Description:</label>
                <textarea name="description" id="description" v-model="newTodo.description" class="form-control" rows="5"></textarea>
              </div>
              <div class="col-12 text-center">
                <button class="btn btn-sm btn-success" @click.prevent="createTodo()"><i class="fas fa-save"></i> save Todo</button>
              </div>
            </div>
          </div>
        </div>
      </b-modal>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Todos',
  data: () => ({
    newTodo: {},
    showModal: false
  }),
  computed: {
    isLoading: {
      get () {
        return this.$store.getters['getLoadingState']
      },
      set (val) {
        this.$store.commit('SET_LOADING_STATE', val)
      }
    },
    ...mapGetters({
      todos: 'getTodos'
    })
  },
  methods: {
    getTodos () {
      this.isLoading = true
      this.$store
        .dispatch('getTodos')
        .then(response => {
          this.isLoading = false
        }, error => {
          this.$swal({
              title: 'Error',
              text: 'Could not load todos - ' + error.message,
              type: 'error'
            })
          this.isLoading = false
        })
    },
    createTodo () {
      this.isLoading = true
      this.$store
        .dispatch('createTodo', this.newTodo)
        .then(response => {
          this.todos.push(response)
          this.cancelModal()
          this.$swal({
              title: 'Success',
              text: 'Todo created',
              type: 'success',
              showConfirmButton: false,
              toast: true,
              position: 'top',
              timer: 2000
            })
        }, error => {
          this.$swal({
              title: 'Error',
              text: 'Could not create new todo - ' + error.message,
              type: 'error'
            })
          this.newTodo = {}
          this.isLoading = true
        })
    },
    updateTodo (todo) {
      this.isLoading = true
      this.$store
        .dispatch('updateTodo', todo)
        .then(response => {
          this.$swal({
              title: 'Success',
              text: 'Todo updated',
              type: 'success',
              showConfirmButton: false,
              toast: true,
              position: 'top',
              timer: 2000
            })
          this.isLoading = false
        }, error => {
          this.$swal({
              title: 'Error',
              text: 'Could update todo - ' + error.message,
              type: 'error'
            })
          this.isLoading = false
        })
    },
    deleteTodo (todo) {
      this.isLoading = true
      this.$store
        .dispatch('deleteTodo', todo.id)
        .then(response => {
          this.todos.splice(this.todos.indexOf(todo), 1)
          this.$swal({
              title: 'Success',
              text: 'Todo deleted',
              type: 'success',
              showConfirmButton: false,
              toast: true,
              position: 'top',
              timer: 2000
            })
          this.isLoading = false
        }, error => {
          this.$swal({
              title: 'Error',
              text: 'Could not delete todo - ' + error.message,
              type: 'error'
            })
          this.isLoading = false
        })
    },
    cancelModal () {
      this.newTodo = {}
      this.showModal = false
    },
    todoStatus (todo) {
      if (todo.done != true) {
        const due = new Date(todo.due_date)
        const now = new Date()
        if ( due < now ) {
          return 'bg-warning'
        } else if ( due.setDate(due.getDate() - 1) - now < 1) {
          return 'bg-default'
        }
      }
      return ''
    }
  },
  created () {
    if (this.todos.length === 0) {
      this.getTodos()
    }
  }
}
</script>