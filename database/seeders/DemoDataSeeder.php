<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Badge;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@lms.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'level' => 1,
                'xp' => 0,
                'next_level_xp' => 100,
            ]
        );

        // Create student user
        $student = User::firstOrCreate(
            ['email' => 'student@lms.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'student',
                'level' => 1,
                'xp' => 0,
                'next_level_xp' => 100,
            ]
        );

        // Create teacher user
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@lms.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'level' => 1,
                'xp' => 0,
                'next_level_xp' => 100,
            ]
        );

        // Create demo courses
        $courses = [
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript. Perfect for beginners who want to start their journey in web development.',
                'created_by' => $admin->id,
                'thumbnail' => null,
            ],
            [
                'title' => 'PHP & Laravel Mastery',
                'description' => 'Master PHP programming and the Laravel framework. Build modern web applications with best practices and advanced techniques.',
                'created_by' => $admin->id,
                'thumbnail' => null,
            ],
            [
                'title' => 'Database Design & SQL',
                'description' => 'Learn database design principles and SQL queries. Understand how to create efficient and scalable database systems.',
                'created_by' => $teacher->id,
                'thumbnail' => null,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::firstOrCreate(
                ['title' => $courseData['title']],
                $courseData
            );

            // Add materials and quizzes for each course
            if ($course->title === 'Introduction to Web Development') {
                $this->seedWebDevCourse($course);
            } elseif ($course->title === 'PHP & Laravel Mastery') {
                $this->seedLaravelCourse($course);
            } elseif ($course->title === 'Database Design & SQL') {
                $this->seedDatabaseCourse($course);
            }
        }

        // Create badges
        $badges = [
            ['name' => 'First Steps', 'description' => 'Complete your first quiz', 'icon' => 'fa-solid fa-star', 'min_xp' => 0],
            ['name' => 'Knowledge Seeker', 'description' => 'Earn 100 XP', 'icon' => 'fa-solid fa-book', 'min_xp' => 100],
            ['name' => 'Quiz Master', 'description' => 'Earn 500 XP', 'icon' => 'fa-solid fa-trophy', 'min_xp' => 500],
            ['name' => 'Learning Champion', 'description' => 'Earn 1000 XP', 'icon' => 'fa-solid fa-crown', 'min_xp' => 1000],
        ];

        foreach ($badges as $badgeData) {
            Badge::firstOrCreate(
                ['name' => $badgeData['name']],
                $badgeData
            );
        }

        echo "Demo data seeded successfully!\n";
        echo "Admin: admin@lms.com / password\n";
        echo "Student: student@lms.com / password\n";
        echo "Teacher: teacher@lms.com / password\n";
    }

    private function seedWebDevCourse($course)
    {
        // Material 1: HTML Basics
        $material1 = Material::firstOrCreate(
            ['title' => 'HTML Basics', 'course_id' => $course->id],
            [
                'content' => 'HTML (HyperText Markup Language) is the standard markup language for creating web pages. It describes the structure of web pages using markup. HTML elements are the building blocks of HTML pages.',
                'xp_reward' => 50,
            ]
        );

        $quiz1 = Quiz::firstOrCreate(
            ['title' => 'HTML Fundamentals Quiz', 'material_id' => $material1->id],
            [
                'xp_reward' => 100,
                'time_limit' => 10,
                'passing_score' => 70,
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'What does HTML stand for?'],
            [
                'options' => json_encode([
                    'A' => 'Hyper Text Markup Language',
                    'B' => 'High Tech Modern Language',
                    'C' => 'Home Tool Markup Language',
                    'D' => 'Hyperlinks and Text Markup Language',
                ]),
                'correct_answer' => 'A',
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'Which HTML tag is used for creating a paragraph?'],
            [
                'options' => json_encode([
                    'A' => '<paragraph>',
                    'B' => '<p>',
                    'C' => '<text>',
                    'D' => '<para>',
                ]),
                'correct_answer' => 'B',
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'Which HTML tag is used for creating a link?'],
            [
                'options' => json_encode([
                    'A' => '<link>',
                    'B' => '<a>',
                    'C' => '<href>',
                    'D' => '<url>',
                ]),
                'correct_answer' => 'B',
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'What is the correct HTML tag for the largest heading?'],
            [
                'options' => json_encode([
                    'A' => '<heading>',
                    'B' => '<h6>',
                    'C' => '<h1>',
                    'D' => '<head>',
                ]),
                'correct_answer' => 'C',
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'Which attribute is used to provide alternative text for an image?'],
            [
                'options' => json_encode([
                    'A' => 'title',
                    'B' => 'alt',
                    'C' => 'text',
                    'D' => 'description',
                ]),
                'correct_answer' => 'B',
            ]
        );

        // Material 2: CSS Styling
        $material2 = Material::firstOrCreate(
            ['title' => 'CSS Fundamentals', 'course_id' => $course->id],
            [
                'content' => 'CSS (Cascading Style Sheets) is used to style and layout web pages. It controls colors, fonts, spacing, and positioning of HTML elements.',
                'xp_reward' => 50,
            ]
        );

        $quiz2 = Quiz::firstOrCreate(
            ['title' => 'CSS Styling Quiz', 'material_id' => $material2->id],
            [
                'xp_reward' => 100,
                'time_limit' => 10,
                'passing_score' => 70,
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz2->id, 'question_text' => 'Which CSS property is used to change text color?'],
            [
                'options' => json_encode([
                    'A' => 'text-color',
                    'B' => 'font-color',
                    'C' => 'color',
                    'D' => 'text-style',
                ]),
                'correct_answer' => 'C',
            ]
        );

        // Material 3: JavaScript Basics
        $material3 = Material::firstOrCreate(
            ['title' => 'JavaScript Introduction', 'course_id' => $course->id],
            [
                'content' => 'JavaScript is a programming language that enables interactive web pages. It is an essential part of web applications and allows you to implement complex features on web pages.',
                'xp_reward' => 50,
            ]
        );

        $quiz3 = Quiz::firstOrCreate(
            ['title' => 'JavaScript Basics Quiz', 'material_id' => $material3->id],
            [
                'xp_reward' => 150,
                'time_limit' => 15,
                'passing_score' => 75,
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz3->id, 'question_text' => 'Which keyword is used to declare a variable in JavaScript?'],
            [
                'options' => json_encode([
                    'A' => 'var, let, const',
                    'B' => 'variable',
                    'C' => 'string',
                    'D' => 'int',
                ]),
                'correct_answer' => 'A',
            ]
        );
    }

    private function seedLaravelCourse($course)
    {
        $material1 = Material::firstOrCreate(
            ['title' => 'Laravel Introduction', 'course_id' => $course->id],
            [
                'content' => 'Laravel is a web application framework with expressive, elegant syntax. It provides tools for routing, authentication, sessions, and caching.',
                'xp_reward' => 75,
            ]
        );

        $quiz1 = Quiz::firstOrCreate(
            ['title' => 'Laravel Basics Quiz', 'material_id' => $material1->id],
            [
                'xp_reward' => 150,
                'time_limit' => 15,
                'passing_score' => 80,
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'What is Laravel primarily used for?'],
            [
                'options' => json_encode([
                    'A' => 'Mobile app development',
                    'B' => 'Web application development',
                    'C' => 'Game development',
                    'D' => 'Desktop software',
                ]),
                'correct_answer' => 'B',
            ]
        );

        $material2 = Material::firstOrCreate(
            ['title' => 'Eloquent ORM', 'course_id' => $course->id],
            [
                'content' => 'Eloquent is Laravel\'s built-in ORM (Object-Relational Mapping). It makes interacting with your database incredibly simple and elegant.',
                'xp_reward' => 75,
            ]
        );

        $quiz2 = Quiz::firstOrCreate(
            ['title' => 'Eloquent ORM Quiz', 'material_id' => $material2->id],
            [
                'xp_reward' => 200,
                'time_limit' => 20,
                'passing_score' => 80,
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz2->id, 'question_text' => 'Which method is used to retrieve all records in Eloquent?'],
            [
                'options' => json_encode([
                    'A' => 'get()',
                    'B' => 'all()',
                    'C' => 'fetch()',
                    'D' => 'select()',
                ]),
                'correct_answer' => 'B',
            ]
        );
    }

    private function seedDatabaseCourse($course)
    {
        $material1 = Material::firstOrCreate(
            ['title' => 'Database Design Principles', 'course_id' => $course->id],
            [
                'content' => 'Database design is the process of producing a detailed data model. A well-designed database saves disk space, ensures data integrity, and improves query performance.',
                'xp_reward' => 75,
            ]
        );

        $quiz1 = Quiz::firstOrCreate(
            ['title' => 'Database Design Quiz', 'material_id' => $material1->id],
            [
                'xp_reward' => 150,
                'time_limit' => 15,
                'passing_score' => 75,
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'What does SQL stand for?'],
            [
                'options' => json_encode([
                    'A' => 'Structured Query Language',
                    'B' => 'Simple Question Language',
                    'C' => 'Standard Query Language',
                    'D' => 'System Query Language',
                ]),
                'correct_answer' => 'A',
            ]
        );

        Question::firstOrCreate(
            ['quiz_id' => $quiz1->id, 'question_text' => 'Which SQL command is used to retrieve data from a database?'],
            [
                'options' => json_encode([
                    'A' => 'GET',
                    'B' => 'RETRIEVE',
                    'C' => 'SELECT',
                    'D' => 'FETCH',
                ]),
                'correct_answer' => 'C',
            ]
        );
    }
}
