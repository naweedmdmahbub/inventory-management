/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const excelRoutes = {
  path: '/inventory',
  component: Layout,
  redirect: '/inventory/brands',
  name: 'Inventory',
  meta: { title: 'inventory', icon: 'nested', permissions: ['view brand list'], },
  children: [
    /** Brand */
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
