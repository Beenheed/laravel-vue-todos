<template>
  <div>
    <todos-view></todos-view>
  </div>
</template>

<script>
import TodosView from './components/Todos.vue'
export default {
  name: 'Home',
  data: () => ({
  }),
  components: {TodosView},
}
</script>