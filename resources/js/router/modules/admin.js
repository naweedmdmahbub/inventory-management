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
    
    /** Client managements */
    {
      path: 'clients/view/:id',
      component: () => import('@/views/clients/View'),
      name: 'ViewClient',
      meta: { title: 'viewClient', permissions: ['view client'] },
      hidden: true,
    },
    {
      path: 'clients/edit/:id',
      component: () => import('@/views/clients/Edit'),
      name: 'EditClient',
      meta: { title: 'editClient', permissions: ['update client'] },
      hidden: true,
    },
    {
      path: 'clients/create',
      component: () => import('@/views/clients/Create'),
      name: 'CreateClient',
      meta: { title: 'createClient', permissions: ['add client'] },
      hidden: true,
    },
    {
      path: 'clients',
      component: () => import('@/views/clients/List'),
      name: 'ClientList',
      meta: { title: 'clients', noCache: true, icon: 'list', permissions: ['view client list'] },
    },

    
    /** Supplier managements */
    {
      path: 'suppliers/view/:id',
      component: () => import('@/views/suppliers/View'),
      name: 'ViewSupplier',
      meta: { title: 'viewSupplier', permissions: ['view supplier'] },
      hidden: true,
    },
    {
      path: 'suppliers/edit/:id',
      component: () => import('@/views/suppliers/Edit'),
      name: 'EditSupplier',
      meta: { title: 'editSupplier', permissions: ['update supplier'] },
      hidden: true,
    },
    {
      path: 'suppliers/create',
      component: () => import('@/views/suppliers/Create'),
      name: 'CreateSupplier',
      meta: { title: 'createSupplier', permissions: ['add supplier'] },
      hidden: true,
    },
    {
      path: 'suppliers',
      component: () => import('@/views/suppliers/List'),
      name: 'SupplierList',
      meta: { title: 'suppliers', noCache: true, icon: 'list', permissions: ['view supplier list'] },
    },


    
    /** Subcontractor managements */
    {
      path: 'subcontractors/view/:id',
      component: () => import('@/views/subcontractors/View'),
      name: 'ViewSubcontractor',
      meta: { title: 'viewSubcontractor', permissions: ['view subcontractor'] },
      hidden: true,
    },
    {
      path: 'subcontractors/edit/:id',
      component: () => import('@/views/subcontractors/Edit'),
      name: 'EditSubcontractor',
      meta: { title: 'editSubcontractor', permissions: ['update subcontractor'] },
      hidden: true,
    },
    {
      path: 'subcontractors/create',
      component: () => import('@/views/subcontractors/Create'),
      name: 'CreateSubcontractor',
      meta: { title: 'createSubcontractor', permissions: ['add subcontractor'] },
      hidden: true,
    },
    {
      path: 'subcontractors',
      component: () => import('@/views/subcontractors/List'),
      name: 'SubcontractorList',
      meta: { title: 'subcontractors', noCache: true, icon: 'list', permissions: ['view subcontractor list'] },
    },
  ],
};

export default adminRoutes;
