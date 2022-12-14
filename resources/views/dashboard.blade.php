<h1>Lista de Repositórios</h1>

<table border="1">
    <tr>
        <td>Id do Repositório</td>
        <td>Nome do Repositório</td>
        <td>Acessar</td>
        <td>Github ID</td>
    </tr>
    @foreach($repousers as $repouser)
    <tr>    
    <td>{{$repouser->repo_id}}></td>
    <td>{{$repouser->repo_name}}</td>
    <td><button class="btn"><a href="{{ route('graph',[ 'username'=>$repouser->owner_name ,'reponame' => $repouser->repo_name] ) }}">Acessar</a></button></td>
    <td>{{$repouser->github_id}}</td>
    </tr>
    @endforeach
 
 
</table>
