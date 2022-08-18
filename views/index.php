<style>
.uk-modal-details .uk-modal-dialog {
  height: 85%;
}
</style>

<div>
  <ul class="uk-breadcrumb">
    <li class="uk-active"><span>@lang('Vercel Deploys')</span></li>
  </ul>
</div>
<div class="uk-hidden">
    <div class="build_hook_url">{{ $build_hook_url }}</div>
    <div class="api_url">{{ $api_url }}</div>
    <div class="projectid">{{ $projectid }}</div>
    <div class="token">{{ $token }}</div>
</div>

<div class="uk-form uk-clearfix">
    <div class="uk-float-right">
      <a class="uk-button uk-button-primary uk-button-large" onclick="deployVercel()">
        <i class="uk-icon-plus uk-icon-justify"></i> @lang('Deploy')
      </a>
    </div>
</div>


<div class="uk-form ">

    
    <table class="uk-table uk-table-tabbed uk-margin-top">
         <thead>
        <tr>
          <th class="uk-text-small uk-link-muted uk-noselect" >
            @lang('Created')
          </th>
          <th class="uk-text-small uk-link-muted uk-noselect">
            @lang('Url')
          </th>
          <th class="uk-text-small uk-link-muted uk-noselect" >
            @lang('State')
          </th>
        </tr>
      </thead>
        <tbody id="tbody"></tbody>
    </table>


</div>
<script>
var build_hook_url = document.querySelector('.build_hook_url').textContent;
var api_url = document.querySelector('.api_url').textContent;
var projectid = document.querySelector('.projectid').textContent;
var token = document.querySelector('.token').textContent;


function manageErrors(response) {
    if(!response.ok){
          const responseError = {
               statusText: response.statusText,
               status: response.status
          };
          throw(responseError);
    }
    return response;
}

    
function deployVercel(){
    UIkit.modal.confirm("Triggering a new deploy on Vercel. Are you sure?", function() {
        fetch( build_hook_url)
            .then(manageErrors)
            .then(function(response) {
        return response.json();
        })
            .then(function(data) {
            App.ui.notify(App.i18n.get("Fetching deploy status..."), "success");
            setTimeout(renderVercel, 4000)
        })
        .catch(function(error) {
            App.ui.notify(App.i18n.get("Cannot deploy to Vercel or configuration error!"), "danger");
    
        });
    });
        
    console.log('deployVercel Trigger');
      
}


async function getVercel() {
    
    try {
        let res = await fetch( api_url + '?projectid=' + projectid, {
            method: 'GET',
            headers: { 'Authorization': 'Bearer '+ token }
        });
        return await res.json();
        
    }catch (e) {
        App.ui.notify(App.i18n.get("Cannot fetch deploys from Vercel or configuration error! Try again later."), "danger");

    }
    
}

async function renderVercel() {
    
    try {
        let getdatas = await getVercel();

        let html = '';
        
        getdatas.deployments.map(deploy => {
            let htmlSegment = 
            `<tr>
                <td><span class="uk-badge uk-badge-outline uk-text-muted">${new Date(deploy.created)}</span></td>
                <td><a href="https://${deploy.url}" target="_blank">${deploy.url}</a></td>
                <td><span class="uk-badge uk-text-small ${deploy.state === 'READY' ? 'uk-badge-success' : 'uk-badge-warning'} "><i class="${deploy.state === 'READY' ? 'uk-icon-eye uk-icon-justify' : 'uk-icon-spinner uk-icon-spin'}"></i>${deploy.state}</span></td>
            </tr>`;
            html += htmlSegment;
        });
        
        let container = document.querySelector('#tbody');
        container.innerHTML = html;
        
        updateVercel(getdatas.deployments[0].state);
        
        console.log('renderVercel Trigger');
    
    } catch (e) {
        App.ui.notify(App.i18n.get("Cannot fetch deploys from Vercel or configuration error! Try again later."), "danger");

    }
    
}
 
function updateVercel(state , notify){
    
    const mysetTimeout = setTimeout(renderVercel, 15000);
    
    console.log('updateVercel Trigger');
    
    if(state === 'READY'){
        clearTimeout(mysetTimeout);

    }
}

renderVercel()

    
</script>