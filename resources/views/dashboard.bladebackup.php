<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                
                
                </div>
            </div>
        </div>
    </div>

    @foreach($repousers as $repouser)
        <p>{{ $repouser->repo_name }} -- {{ $repouser-> repo_id }}</p> 
    @endforeach

    <table border="1">
    <tr>
        <td>Id do Repositório</td>
        <td>Nome do Repositório</td>
        <td>Seleção</td>
    </tr>
    @foreach($repousers as $repouser)
    <tr>    
    <td>{{$repousers['repo_id']}}></td>
    <td>{{$repousers['repo_name']}}</td>
    <td><input type="button" value="Acessar"></td>
    </tr>
    @endforeach
</table>



</x-app-layout> 


