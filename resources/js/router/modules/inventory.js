/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const excelRoutes = {
  path: '/inventory',
  component: Layout,
  redirect: '/inventory/brands',
  name: 'Inventory',
  meta: {
    title: 'inventory',
    icon: 'nested',
    permissions: ['view menu excel'],
  },
  children: [
    {
      path: 'export-excel',
      component: () => import('@/views/excel/ExportExcel'),
      name: 'exportExcel',
      meta: { title: 'exportExcel' },
    },

    
    /** Brand */
    // {
    //   path: 'brands/create',
    //   component: () => import('@/views/brands/Create'),
    //   name: 'CreateBrand',
    //   meta: { title: 'createBrand', icon: 'edit', permissions: ['add brand'] },
    //   hidden: true,
    // },
    // {
    //   path: 'brands/edit/:id',
    //   component: () => import('@/views/brands/Edit'),
    //   name: 'BrandEdit',
    //   meta: { title: 'editBrand', icon: 'list', permissions: ['update brand'] },
    //   hidden: true,
    // },
    {
      path: 'brands',
      component: () => import('@/views/brands/List'),
      name: 'BrandList',
      meta: { title: 'brands', icon: 'list', permissions: ['view brand list'] },
    },

    /** Unit */
    {
      path: 'units',
      component: () => import('@/views/units/List'),
      name: 'UnitList',
      meta: { title: 'units', icon: 'list', permissions: ['view unit list'] },
    },
    /** Category */
    {
      path: 'categories',
      component: () => import('@/views/categories/List'),
      name: 'CategoryList',
      meta: { title: 'categories', icon: 'list', permissions: ['view category list'] },
    },
  ],
};

export default excelRoutes;
