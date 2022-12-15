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
    permissions: ['view project list'],
  },
  children: [
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
      meta: { title: 'createProject', noCache: true, permissions: ['add project'] },
      hidden: true,
    },
    {
      path: 'projects',
      component: () => import('@/views/projects/List'),
      name: 'ProjectList',
      meta: { title: 'projects', noCache: true, icon: 'list', permissions: ['view project list'] },
    },
    
    /** Structure type */
    {
      path: 'structure-types/view/:id',
      component: () => import('@/views/structure-types/View'),
      name: 'ViewStructureType',
      meta: { title: 'viewStructureType', noCache: true, permissions: ['manage structure type'] },
      hidden: true,
    },
    {
      path: 'structure-types/edit/:id',
      component: () => import('@/views/structure-types/Edit'),
      name: 'EditStructureType',
      meta: { title: 'editStructureType', noCache: true, permissions: ['manage structure type'] },
      hidden: true,
    },
    {
      path: 'structure-types/create',
      component: () => import('@/views/structure-types/Create'),
      name: 'CreateStructureType',
      meta: { title: 'createStructureType', noCache: true, permissions: ['manage structure type'] },
      hidden: true,
    },
    {
      path: 'structure-types',
      component: () => import('@/views/structure-types/List'),
      name: 'StructureTypeList',
      meta: { title: 'structureTypes', noCache: true, icon: 'list', permissions: ['manage structure type'] },
    },

    
    /** Structure */
    {
      path: 'structures/view/:id',
      component: () => import('@/views/structures/View'),
      name: 'ViewStructure',
      meta: { title: 'viewStructure', noCache: true, permissions: ['manage structure'] },
      hidden: true,
    },
    {
      path: 'structures/edit/:id',
      component: () => import('@/views/structures/Edit'),
      name: 'EditStructure',
      meta: { title: 'editStructure', noCache: true, permissions: ['manage structure'] },
      hidden: true,
    },
    {
      path: 'structures/create',
      component: () => import('@/views/structures/Create'),
      name: 'CreateStructure',
      meta: { title: 'createStructure', noCache: true, permissions: ['manage structure'] },
      hidden: true,
    },
    {
      path: 'structures',
      component: () => import('@/views/structures/List'),
      name: 'StructureList',
      meta: { title: 'structureTypes', noCache: true, icon: 'list', permissions: ['manage structure'] },
    },

  ],
};

export default projectRoutes;
