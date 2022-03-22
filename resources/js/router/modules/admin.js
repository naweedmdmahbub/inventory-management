/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const adminRoutes = {
  path: '/administrator',
  component: Layout,
  redirect: '/administrator/users',
  name: 'Administrator',
  alwaysShow: true,
  meta: {
    title: 'administrator',
    icon: 'admin',
    permissions: ['view menu administrator'],
  },
  children: [
    /** User managements */
    {
      path: 'users/edit/:id(\\d+)',
      component: () => import('@/views/users/UserProfile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: 'users',
      component: () => import('@/views/users/List'),
      name: 'UserList',
      meta: { title: 'users', icon: 'user', permissions: ['manage user'] },
    },
    /** Role and permission */
    {
      path: 'roles',
      component: () => import('@/views/role-permission/List'),
      name: 'RoleList',
      meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    },
    {
      path: 'articles/create',
      component: () => import('@/views/articles/Create'),
      name: 'CreateArticle',
      meta: { title: 'createArticle', icon: 'edit', permissions: ['manage article'] },
      hidden: true,
    },
    {
      path: 'articles/edit/:id(\\d+)',
      component: () => import('@/views/articles/Edit'),
      name: 'EditArticle',
      meta: { title: 'editArticle', noCache: true, permissions: ['manage article'] },
      hidden: true,
    },
    {
      path: 'articles',
      component: () => import('@/views/articles/List'),
      name: 'ArticleList',
      meta: { title: 'articleList', icon: 'list', permissions: ['manage article'] },
    },

    
    /** Client managements */
    {
      path: 'clients/view/:id',
      component: () => import('@/views/clients/View'),
      name: 'ViewClient',
      meta: { title: 'viewClient', noCache: true, permissions: ['view client'] },
      hidden: true,
    },
    {
      path: 'clients/edit/:id',
      component: () => import('@/views/clients/Edit'),
      name: 'EditClient',
      meta: { title: 'editClient', noCache: true, permissions: ['update client'] },
      hidden: true,
    },
    {
      path: 'clients/create',
      component: () => import('@/views/clients/Create'),
      name: 'CreateClient',
      meta: { title: 'createClient', noCache: true, permissions: ['add client'] },
      hidden: true,
    },
    {
      path: 'clients',
      component: () => import('@/views/clients/List'),
      name: 'ClientList',
      meta: { title: 'clients', icon: 'list', permissions: ['view client list'] },
    },
  ],
};

export default adminRoutes;
