<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();

        return view('user.index',['users' => $users]);
    }

    public function edit($id){
        try{
            $user = User::findOrFail($id);

            return view('user.edit',['user'=> $user]);
        }catch(\Exception $e){
            return back()->with('error', 'Lấy thông tin người dùng thất bại!');
        }
    }

    public function editCustomer($id){
        // try{
            $user = User::findOrFail($id);

            return view('user.editCustomer',['user'=> $user]);
        // }catch(\Exception $e){
        //     return back()->with('error', 'Lấy thông tin người dùng thất bại!');
        // }
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:10',
            'address' => 'nullable|string',
            'role' => 'required|in:Admin,Customer,Staff'
        ]);


        DB::beginTransaction();
        try{
            User::where('UserID', $id)->update([
                'Fullname' => $request->name,
                'PhoneNumber' => $request->phone,
                'Address' => $request->address,
                'Role' => $request->role
            ]);

            DB::commit();


            if(auth()->user()->Role == 'Admin'){
                return redirect()->route('admin.user.index')->with('sucess', 'Cập nhật thông tin người dùng thành công!');
            }else{
                $user = User::findOrFail($id);
                return redirect("user/profile/$user->UserID")->with('sucess', 'Cập nhật thông tin người dùng thành công!');
            }

        }catch(\Exception $e){
            DB::rollBack();

            return back()->with('error', 'Cập nhật thông tin người dùng thất bại'. $e->getMessage());
        }
    }

    public function destroy($id){
        DB::beginTransaction();

        try{
            User::destroy($id);

            DB::commit();

            return redirect()->route('admin.user.index')->with('success', 'Xóa tài khoản thành công!');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.user.index')->with('error', 'Xóa tài khoản không thành công! '. $e->getMessage());
        }
    }

    public function overall($id){
        $user = User::findOrFail($id);

        return view('user.overall',['user'=> $user]);
    }

    public function profile($id){
        $user = User::findOrFail($id);

        return view('user.profile',['user'=> $user]);
    }
}
