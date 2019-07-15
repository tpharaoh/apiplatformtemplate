import BookList from '../pages/book/List'
import BookCreate from '../pages/book/Create'
import BookUpdate from '../pages/book/Update'
import BookShow from '../pages/book/Show'

export default [
  {
    name: 'BookList',
    path: '/books/',
    component: BookList,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: 'BookCreate',
    path: '/books/create',
    component: BookCreate,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: 'BookUpdate',
    path: '/books/edit/:id',
    component: BookUpdate,
    meta: {
      requiresAuth: true
    }
  },
  {
    name: 'BookShow',
    path: '/books/:id',
    component: BookShow,
    meta: {
      requiresAuth: true
    }
  }
]
