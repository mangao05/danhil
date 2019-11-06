<template>
    <div class="card">
        <div class="card-header"><label for="">Add Position</label></div>
        <div class="card-body">
            
            <input type="text" name="position" id="" v-model="form.position" class="form-control" placeholder="enter position..." :class="{ 'is-invalid': form.errors.has('position') }">
            <has-error :form="form" field="position"></has-error>

            <div class="pt-3">
                 <button class="btn btn-success form-control" @click="addPosition">Save</button>
            </div>

        </div>  

      
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    position:'',
                })
            }
        },
        methods: {
            addPosition(){
                this.form.post('api/position')
                .then(({data}) => {
                    this.$toastr.s('New Position has been successfully added','Success');
                    Fire.$emit('createdSuccess');
                    this.form.reset()
                    this.form.clear()
                    
                })
                .catch(() => {

                });
            }
        },
      
        mounted() {
         
            console.log('Component mounted.')
        }
    }
</script>
