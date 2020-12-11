<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Database;
use Kreait\Firebase\Firestore;

class PostController extends Controller
{
    public function __construct(Database $database, Firestore $firestore)
    {
        $this->database = $database;
        $this->firestore = $firestore;
    }

    public function index()
    {
        $post = $this->database
            ->getReference('blog/posts')->getSnapshot()->getValue();
        return response()->json(['message' => 'List Post', 'data' => compact('post')]);
    }

    public function show(Request $request, $id)
    {
        $post = $this->database
            ->getReference('blog/posts/' . $id)->getSnapshot()->getValue();
        return response()->json(['message' => 'List Post', 'data' => compact('post')]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => 'Invalid input', 'data' => $errors], 400);
        }

        $post = $this->database
            ->getReference('blog/posts')
            ->push($request->all());

        return response()->json(['message' => 'Post created', 'data' => compact('post')]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => 'Invalid input', 'data' => $errors], 400);
        }
        $updated = $this->database
            ->getReference('blog/posts/' . $id)->set($request->all());
        $post = $this->database
            ->getReference('blog/posts/' . $id)->getSnapshot()->getValue();
        return response()->json(['message' => 'post created', 'data' => compact('post')]);
    }

    public function delete(Request $request, $id)
    {
        $deleted = $this->database
            ->getReference('blog/posts/' . $id)->remove();
        return response()->json(['message' => 'post deleted']);
    }

    public function indexFirestore()
    {
        $database = $this->firestore->database();
        $result = $database->collection('posts')->documents();
        $posts = [];
        foreach ($result as $document) {
            if ($document->exists()) {
                $data = array_merge($document->data(), ['id' => $document->id()]);
                array_push($posts, $data);
            }
        }
        return response()->json(['message' => 'List Post', 'data' => compact('posts')]);
    }

    public function showFirestore(Request $request, $id)
    {
        $database = $this->firestore->database();
        $post = $database->collection('posts')->document($id)->snapshot()->data();
        return response()->json(['message' => 'List Post', 'data' => compact('post')]);
    }

    public function storeFirestore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => 'Invalid input', 'data' => $errors], 400);
        }

        $database = $this->firestore->database();
        $post = ($database->collection('posts')->add($request->all()))->snapshot()->data();

        return response()->json(['message' => 'Post created', 'data' => compact('post')]);
    }

    public function updateFirestore(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['message' => 'Invalid input', 'data' => $errors], 400);
        }
        $database = $this->firestore->database();
        $updated = $database->collection('posts')->document($id)->set($request->all());
        $post = $database->collection('posts')->document($id)->snapshot()->data();
        return response()->json(['message' => 'post created', 'data' => compact('post')]);
    }

    public function deleteFirestore(Request $request, $id)
    {
        $deleted = $this->firestore->database();
        $deleted->collection('posts')->document($id)->delete();
        return response()->json(['message' => 'post deleted']);
    }

}
