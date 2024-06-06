<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $query = User::query();

            return DataTables::of($query)
            ->addColumn('action', function ($item) {
                return '
                    <a href="' . route('user.edit', $item->id ) . '">
                        Edit
                    </a>
                    <form class="inline-block" action="'. route('user.destroy', $item->id ) .'" method="POST">
                        <button class="bg-red-500 text-black rounded-md px-2 py-1 m-2">
                            Delete
                        </button>
                    '. method_field('DELETE') . csrf_field() .'
                    </form>
                ';
            })
            ->rawColumns(['action'])
            ->make();
            // ->addColumn('action', function ($query) {
            //     return view('pages.dashboard.product.action', compact('query'));
            // })
        }

        return view('pages.dashboard.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::findOrFail($user->id);
        return view('pages.dashboard.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();

        $user->update($data);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }
}
