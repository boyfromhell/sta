<template>
    <div class='container'>
        <h2 class="text-center mt-5">Commande  {{ data.nom }}</h2>
        
        <div class="card mt-5">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-md-3">
                        <input type="file" id="file" ref="file" @change="uploadData()"/>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5>Liste des Produits Commandés</h5>
                    </div>
                </div>
                
            </div>
            <div class="card-body" style="max-height:30em;overflow-y: scroll;">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>SKU</th>
                            <th>Désignation</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(produit, index) in produits_commande">
                            <td>{{ index + 1 }}</td>
                            <td scope="row">{{ produit.produit.sku }}</td>
                            <td>{{ produit.produit.nom + ' / ' + produit.produit.variante_une + ' / ' + produit.produit.variante_deux + ' / ' + produit.produit.variante_trois }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td scope="row"></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-5" >
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary" @click="créerDemandesParFournisseur()">Créer les Demandes</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5>Demandes Envoyés</h5>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height:30em;overflow-y: scroll;">
                <table class="table table-striped table-inverse mt-3">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Numéro</th>
                            <th>Fournisseur</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="demande in this.data.demandes">
                                <td scope="row"><a :href="'/demande-achat/' + demande.id">{{ demande.numéro }}</a></td>
                                <td scope="row">{{ demande.fournisseur.nom }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-header text-center">
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary" @click="créerCommandes()">Créer les Commandes</button>
                    </div>
                    <div class="col-md-6 text-center">
                        <h5>Bons de Commande</h5>
                    </div>
                </div>
                
            </div>
            <div class="card-body" style="max-height:30em;overflow-y: scroll;">
                <table class="table table-striped table-inverse mt-5">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Numéro</th>
                            <th>Fournisseur</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="commande in data.commandes">
                                <td scope="row"><a :href="'/bon-commande/' + commande.id">BC00{{ commande.commande_id }}</a></td>
                                <td scope="row">{{ commande.fournisseur.nom }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data'],
    data(){
        return {
            file: '',
            produits_commande: [],
            articles: []
        }
    },
    methods:{
        uploadData(){
            this.file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('commande', this.data.id)

            axios.post('/produits-commande/api/upload',formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        créerDemandesParFournisseur(){
            axios.get('/demande-achat/api/créerDemandesParFournisseur/' + this.data.id).then(response => {
                console.log(response.data);

            }).catch(error => {
                console.log(error);
            });
        },
        créerCommandes(){
            axios.get('/bon-commande/api/créerCommandes/' + this.data.id).then(response => {
                console.log(response.data);
                
            }).catch(error => {
                console.log(error);
            });
        }
    },
    mounted(){
        axios.get('/produits-commande/api/all/' + this.data.id).then(response => {
            this.produits_commande = response.data;

        }).catch(error => {
            console.log(error);
        });

        axios.get('/article/api/all').then(response => {
            this.articles = response.data
            console.log(response.data);
            
        }).catch(error => {
            console.log(error);
        });
        
    }
}
</script>