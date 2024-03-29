<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input v-model="query.keyword" :placeholder="$t('table.keyword')" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter" />
      <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">
        {{ $t('table.search') }}
      </el-button>
      <router-link to="/administrator/suppliers/create">
        <el-button
          v-permission="['add supplier']"
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

      <el-table-column prop="name" align="center" sortable label="Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span>
        </template>
      </el-table-column>

      <el-table-column prop="business_name" align="center" sortable label="Business Name" width="200">
        <template slot-scope="scope">
          <span>{{ scope.row.business_name }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="email" align="center" sortable label="Email">
        <template slot-scope="scope">
          <span>{{ scope.row.email }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="contact_person" align="center" sortable label="Contact Person">
        <template slot-scope="scope">
          <span>{{ scope.row.contact_person }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="contact_no" align="center" sortable label="Contact No">
        <template slot-scope="scope">
          <span>{{ scope.row.contact_no }}</span>
        </template>
      </el-table-column>
      <el-table-column prop="address" align="center" sortable label="Address">
        <template slot-scope="scope">
          <span>{{ scope.row.address }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <!-- <el-button
            v-permission="['view supplier']"
            type="warning"
            size="small"
            icon="el-icon-view"
            @click="handleShow(scope.row.id);"
          >
            View
          </el-button> -->
          
          <router-link :to="'/administrator/suppliers/view/'+scope.row.id">
            <el-button
              v-permission="['view supplier']"
              type="warning"
              size="small"
              icon="el-icon-view"
            >
              View
            </el-button>
          </router-link>
          <router-link :to="'/administrator/suppliers/edit/'+scope.row.id">
            <el-button
              v-permission="['update supplier']"
              type="primary"
              size="small"
              icon="el-icon-edit"
            >
              Edit
            </el-button>
          </router-link>
          <el-button
            v-permission="['manage supplier']"
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
const supplierResource = new Resource('suppliers');

export default {
  name: 'SupplierList',
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
      newSupplier: {},
    };
  },
  computed: {},
  async mounted() {
    console.log('mounted list');
    await this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;
      const { data, meta } = await supplierResource.list(this.query);
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
      this.$confirm('This will permanently delete supplier ' + name + '. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        supplierResource.destroy(id).then(response => {
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
        const tHeader = ['SL', 'Supplier ID', 'Name', 'Business Name', 'Contact Person', 'Contact No', 'Address'];
        const filterVal = ['index', 'id', 'full_name', 'business_name', 'contact_person', 'contact_no', 'address'];
        const data = this.formatJson(filterVal, this.list);
        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'supplier-list',
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
