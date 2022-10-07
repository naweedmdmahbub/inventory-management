<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <router-link v-if="checkPermission(['add project'])" to="/project/projects/create">
        <el-button
          v-permission="['add project']"
          class="filter-item"
          style="margin-left: 10px;"
          type="primary"
          icon="el-icon-plus"
        >
          {{ $t('table.add') }}
        </el-button>
      </router-link>
      <el-button v-waves :loading="downloading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">
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

      <el-table-column prop="name" align="center" sortable label="Name">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="client_name" align="center" sortable label="Client">
        <template slot-scope="scope">
          <span>{{ scope.row.client_name }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="code" align="center" sortable label="Code">
        <template slot-scope="scope">
          <span>{{ scope.row.code }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="location" align="center" sortable label="Location">
        <template slot-scope="scope">
          <span>{{ scope.row.location }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="description" align="center" sortable label="Description" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.description.length &lt; 50 ? scope.row.description : scope.row.description.substring(0, 50) +'...' }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="start_date" align="center" sortable label="Start Date">
        <template slot-scope="scope">
          <span>{{ scope.row.start_date }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="end_date" align="center" sortable label="End Date">
        <template slot-scope="scope">
          <span>{{ scope.row.end_date }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">          
          <router-link v-if="checkPermission(['view project'])" :to="'/project/projects/view/'+scope.row.id">
            <el-button
              v-permission="['view project']"
              type="warning"
              size="small"
              icon="el-icon-view"
            >
              View
            </el-button>
          </router-link>
          <router-link v-if="checkPermission(['update project'])" :to="'/project/projects/edit/'+scope.row.id">
            <el-button
              v-permission="['update project']"
              type="primary"
              size="small"
              icon="el-icon-edit"
            >
              Edit
            </el-button>
          </router-link>
          <el-button
            v-permission="['manage project']"
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.full_name);"
          >
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>


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
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive
import permission from '@/directive/permission'; // Permission directive
import checkPermission from '@/utils/permission'; // Permission checking
const projectResource = new Resource('projects');

export default {
  name: 'ProjectList',
  components: { Pagination },
  directives: { waves, permission },
  data() {
    return {
      list: null,
      total: 0,
      loading: true,
      downloading: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
      },
      newProject: {},
    };
  },
  computed: {},
  async mounted() {
    console.log('mounted list');
    await this.getList();
  },
  methods: {
    checkPermission,
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await projectResource.list(this.query);
      this.list = data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      console.log('hi getList');
      this.total = meta.total;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
    handleDelete(id, name) {
      this.$confirm('This will permanently delete project ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        projectResource.destroy(id).then(response => {
          this.$message({
            type: 'success',
            message: 'Delete completed',
          });
          this.handleFilter();
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
        const tHeader = ['SL', 'Project ID', 'Name', 'Code', 'Description', 'Start Date', 'End Date'];
        const filterVal = ['index', 'id', 'full_name', 'code', 'description', 'start_date', 'end_date'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'project-list',
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



<style lang="scss" scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
.dialog-footer {
  text-align: left;
  padding-top: 0;
  margin-left: 150px;
}
.app-container {
  flex: 1;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
  .block {
    float: left;
    min-width: 250px;
  }
  .clear-left {
    clear: left;
  }
}
</style>
