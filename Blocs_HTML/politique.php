<div class="modal fade" id="myModal" role="dialog" >
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header">
          
          <h4 class="modal-title">PLATON - FFSFP</h4>
        </div>
        <div class="modal-body" style='overflow-y:scroll; width: auto; height: 500px;'>
         <p class="font-weight-normal"><strong>Objet du traitement (finalité et base légale)</strong></p>
         L'association FFSFP a mis en place une plateforme de traitement des ouvertures de cours et des nouvelles adhésions afin de disposer des informations nécessaires sur les formateurs et les apprenants pour délivrer les attestations ou diplômes de secourisme. Cette plateforme permet également de gérer les adhésions à l'association. Ce traitement est réalisé en lien avec un contrat (adhésion ou formation).
          <p class="font-weight-normal"><strong>Données enregistrées par la FFSFP</strong></p>
          <ul> 
             <li>Identité : Nom, Prénom, Date et Lieu de Naissance, Adresse, Téléphone, Adresse Courriel, Profession, Dates et montants de cotisations.</li> 
             <li> Diplômes et Qualifications en secourisme.</li> 
             <li>Identifiant et mot de passe de connexion (cripté).</li> 
         </ul>
         <p class="font-weight-normal"><strong>Destinataires des données</strong></p>
         <ul> 
             <li>Les personnes assurant le traitement des formations et /ou cotisations.</li> 
           
         </ul>

          <p class="font-weight-normal"><strong>Durée de conservation des données en base active</strong></p>
           <ul> 
             <li>1 an après avoir quitté l'association.</li>       
         </ul>

          <p class="font-weight-normal"><strong>Droits des personnes</strong></p>
          Vous pouvez accéder aux données vous concernant. Vous disposez également d'un droit d’opposition, d’un droit de rectification et d’un droit à la limitation du traitement de vos données (cf. www.cnil.fr pour plus d’informations sur vos droits).
          Pour exercer ces droits ou pour toute question sur le traitement de vos données dans ce dispositif, vous pouvez contacter le Président de la FFSFP (president@ffsfsp.org).

          <p>Si vous estimez, après nous avoir contactés, que vos droits Informatique et Libertés ne sont pas respectés ou que le dispositif de contrôle d’accès n’est pas conforme aux règles de protection des données, vous pouvez adresser une réclamation en ligne à la CNIL ou par voie postale.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        </div>
      </div>
      
    </div>
  </div>
		

		<script type="text/javascript">
			

          $(document).ready(function() {
           if(Cookies.set('cookiebar')==undefined)
           {
            $('body').append('<div class="cooki " id="cooki">En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de Cookies pour vous réaliser des statistiques de visites. <a href="" data-toggle="modal" data-target="#myModal" >En savoir plus </a><div class="cookie_btn" id="cookie_btn">Ok</div></div> ');

             	$('#cookie_btn').click(function(e){
                     e.preventDefault();
                     $('#cooki').hide();
                     Cookies.set('cookiebar', 'view', { expires: 30*12 });

             	});

             }
             	 
             
          });

		
		</script>
