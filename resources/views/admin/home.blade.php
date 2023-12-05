@extends('admin.layout.app')

@section('app')
    <h1>Hello, {{ auth()->user()->name }}!</h1>

    <div class="card">
        <div class="card-body">
            <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa suscipit beatae, aliquid omnis reiciendis blanditiis libero ad sequi accusantium obcaecati, maiores eligendi similique dolore, magni laborum esse eveniet. Nobis voluptatum dignissimos sapiente adipisci dolorum! Quibusdam impedit eligendi quas dicta quae eveniet obcaecati quaerat tenetur doloribus, animi possimus debitis earum sequi eius deserunt nam quo maxime aperiam! Omnis aspernatur accusantium sequi error repudiandae dolorum consequuntur aut soluta ipsam, optio voluptatem harum veniam autem placeat officia assumenda architecto distinctio libero nostrum delectus tempore? Doloribus soluta voluptatem nihil id porro esse magni expedita rerum asperiores iusto aliquid, facilis accusamus vel repellendus animi. Nam recusandae ducimus placeat, animi voluptates deserunt earum, voluptatibus odio quis autem, dolorem fugiat ad et. Aut quam provident possimus quibusdam.</span>
        </div>
    </div>
@endsection
