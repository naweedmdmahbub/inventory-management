/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const projectRoutes = {
  path: '/project',
  component: Layout,
  redirect: '/project/projects',
  name: 'Project',
  meta: {
    title: 'project',
    icon: 'nested',
    permissions: ['view menu excel'],
  },
  children: [
    // {
    //   path: 'export-excel',
    //   component: () => import('@/views/excel/ExportExcel'),
    //   name: 'exportExcel',
    //   meta: { title: 'exportExcel' },
    // },

    /** Project managements */
    {
      path: 'projects/view/:id',
      component: () => import('@/views/projects/View'),
      name: 'ViewProject',
      meta: { title: 'viewProject', permissions: ['view project'] },
      hidden: true,
    },
    {
      path: 'projects/edit/:id',
      component: () => import('@/views/projects/Edit'),
      name: 'EditProject',
      meta: { title: 'editProject', permissions: ['update project'] },
      hidden: true,
    },
    {
      path: 'projects/create',
      component: () => import('@/views/projects/Create'),
      name: 'CreateProject',
      meta: { title: 'createProject', permissions: ['add project'] },
      hidden: true,
    },
    {
      path: 'projects',
      component: () => import('@/views/projects/List'),
      name: 'ProjectList',
      meta: { title: 'projects', noCache: true, icon: 'list', permissions: ['view project list'] },
    },

  ],
};

export default projectRoutes;
