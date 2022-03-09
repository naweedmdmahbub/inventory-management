<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="query.keyword"
        :placeholder="$t('table.keyword')"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-button
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >
        {{ $t('table.search') }}
      </el-button>
      <el-button
        v-permission="['add category']"
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >
        {{ $t('table.add') }}
      </el-button>
      <el-button
        v-waves
        :loading="downloading"
        class="filter-item"
        type="primary"
        icon="el-icon-download"
        @click="handleDownload"
      >
        {{ $t('table.export') }}
      </el-button>
    </div>

    <el-table
      v-loading="loading"
      :data="list"
      border
      fit
      highlight-current-row
    >
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="name" align="center" sortable label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="code" align="center" sortable label="Code" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>


      <el-table-column prop="image" align="center" sortable label="Image">
        <template slot-scope="scope">
          <img
            v-if="scope.row.image !==null"
            :src="'/uploads/categories/' + scope.row.image.filename"
            width="100"
            height="100"
          >
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <el-button
            v-permission="['view category']"
            type="warning"
            size="small"
            icon="el-icon-view"
            @click="handleShow(scope.row.id);"
          >
            View
          </el-button>
          <el-button
            v-permission="['update category']"
            type="primary"
            size="small"
            icon="el-icon-edit"
            @click="handleEdit(scope.row.id);"
          >
            Edit
          </el-button>
          <el-button
            v-permission="['manage category']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name);"
          >
            Delete
          </el-button>
        </template>
      </el-table-column>

    </el-table>

    <!-- Create Modal -->
    <Create
      ref="createRef"
      :category="currentBrand"
      @dismissDialog="dismissDialog"
    />
    <!-- Edit Modal -->
    <Edit
      ref="editRef"
      :category="currentBrand"
      @dismissDialog="dismissDialog"
    />
    <!-- Show Modal -->
    <Show
      ref="showRef"
      :category="currentBrand"
    />

    <pagination 
      v-show="total>0"
      :total="total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />
  </div>
</template>


<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import waves from '@/directive/waves'; // Waves directive
import axios from 'axios';
import permission from '@/directive/permission'; // Permission directive
import Resource from '@/api/resource';
import Create from './Create';
import Edit from './Edit';
import Show from './Show';
const categoryResource = new Resource('categories');

export default {
  name: 'BrandList',
  components: { Pagination, Create, Edit, Show },
  directives: { waves, permission },
  data() {
    return {
      list: [],
      total: 0,
      loading: true,
      downloading: false,
      formTitle: 'Create Brand',
      currentBrand: {
        name: '',
        code: '',
        image: '',
      },
      query: {
        page: 1,
        limit: 10,
        keyword: '',
      },
      currentComponent: 'Edit',
      errors: [],
    };
  },
  async mounted() {
    await this.getList();
  },
  methods: {
    dismissDialog() {
      this.currentBrand = {
        name: '',
        code: '',
        image: '',
      };
      this.getList();
    },

    async getList() {
      this.loading = true;
      const response = await categoryResource.list(this.query);
      // console.log('getList:', response, response.data);
      this.list = response.data;
      this.total = response.meta.total;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleCreate(){
      this.$refs.createRef.handleCreateModal();
    },
    handleEdit(id){
      this.currentBrand = this.list.find(category => category.id === id);
      this.$refs.editRef.handleEditModal(id);
    },
    handleShow(id){
      this.currentBrand = this.list.find(category => category.id === id);
      this.$refs.showRef.handleShowModal(id);
    },

    handleDelete(id, name) {
      this.$confirm('This will permanently delete category ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        axios
          .delete('api/categories/'+id)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Delete completed',
            });
            this.getList();
          }).catch(error => {
            console.log(error);
          });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled',
        });
      });
    },


    handleDownload() {
      this.downloading = true;
      import('@/vendor/Export2Excel').then(excel => {
        const tHeader = ['id', 'name', 'code'];
        const filterVal = ['id', 'name', 'code'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'category-list',
        });
        this.downloading = false;
      });
    },
    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => v[j]));
    },
  },
};
</script>
