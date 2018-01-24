<template lang="html">
  <div>
    <section class="todoapp">
      <header class="header">
        <h1>todos</h1>
        <input class="new-todo" placeholder="What needs to be done?" autofocus @keyup.enter="addTask" v-model="task.title">
      </header>

      <!-- This section should be hidden by default and shown when there are todos -->
      <section class="main" v-if="tasks.length">
        <input class="toggle-all" type="checkbox" @change="toggleAllDoneness">
        <label for="toggle-all">Mark all as complete</label>
        <ul class="todo-list">
          <!-- These are here just to show the structure of the list items -->
          <!-- List items should get the class `editing` when editing and `completed` when marked as completed -->
          <li v-for="task in tasks" :class="{completed: task.done}">
            <div class="view">
              <input class="toggle" type="checkbox" v-model="task.done" @change="toggleDoneness(task)">
              <label @dblclick="doEditing(task, $event)">{{ task.title }}</label>
              <button class="destroy" @click="deleteTask(task)"></button>
            </div>
            <input
              class="edit"
              v-model="task.title"
              @blur="doneEditing(task, $event)"
              @keyup.enter="doneEditing(task, $event)"
            >
          </li>
        </ul>
      </section>

      <!-- This footer should hidden by default and shown when there are todos -->
      <footer class="footer" v-if="allTasks.length">
        <!-- This should be `0 items left` by default -->
        <span class="todo-count"><strong>{{ activeTasks.length }}</strong> item left</span>

        <!-- Remove this if you don't implement routing -->
        <ul class="filters">
          <li>
            <a :class="{ selected: ['root', 'all'].indexOf($route.name) >= 0 }" href="#/all">All</a>
          </li>
          <li>
            <a :class="{ selected: ['active'].indexOf($route.name) >= 0 }" href="#/active">Active</a>
          </li>
          <li>
            <a :class="{ selected: ['completed'].indexOf($route.name) >= 0 }" href="#/completed">Completed</a>
          </li>
        </ul>

        <!-- Hidden if no completed items are left ↓ -->
        <button class="clear-completed" @click="clearCompleted" v-if="completedTasks.length">Clear completed</button>
      </footer>
    </section>

    <footer class="info">
      <p><router-link :to="{name: 'logout'}">Logout as {{ authUser.name }}</router-link></p>
      <p>Double-click to edit a todo</p>
      <p>Created by <a href="https://krisanalfa.github.io">Krisan Alfa Timur</a></p>
      <p>Part of <a href="http://todomvc.com">TodoMVC</a></p>
    </footer>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import * as TYPES from '@/store/mutation-types'

export default {
  name: 'todo',

  data () {
    return {
      task: {
        title: '',
        done: false
      }
    }
  },

  computed: {
    ...mapGetters([
      'allTasks',
      'activeTasks',
      'completedTasks',
      'authUser',
      'authToken'
    ]),

    tasks () {
      const routeName = this.$route.name

      switch (routeName) {
        case 'root':
          return this.allTasks
        case 'all':
          return this.allTasks
        case 'active':
          return this.activeTasks
        case 'completed':
          return this.completedTasks
        default:
          return []
      }
    }
  },

  created () {
    this.authToken && this.$store.dispatch(TYPES.FETCH_TASKS)
  },

  methods: {
    addTask () {
      this.$store.dispatch(TYPES.CREATE_TASK, this.task)

      this.task = {
        id: null,
        user_id: 1,
        title: '',
        done: false
      }
    },

    toggleDoneness (task) {
      this.$store.dispatch(TYPES.UPDATE_TASK, task)
    },

    toggleAllDoneness (event) {
      this.tasks.forEach((task) => {
        task.done = event.target.checked

        this.$store.dispatch(TYPES.UPDATE_TASK, task)
      })
    },

    doEditing (task, event) {
      const target = event.target.closest('li')
      const input = target.querySelector('.edit')

      target.classList.toggle('editing')
      input.focus()
      input.select()
    },

    doneEditing (task, event) {
      event.target.closest('li').classList.toggle('editing')

      this.$store.dispatch(TYPES.UPDATE_TASK, task)
    },

    deleteTask (task) {
      this.$store.dispatch(TYPES.DELETE_TASK, task)
    },

    clearCompleted () {
      this.$store.dispatch(TYPES.CLEAR_COMPLETED_TASKS)
    }
  }
}
</script>
