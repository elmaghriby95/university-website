<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Page;
use App\Models\Result;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@university.edu'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        $settings = [
            'site_name' => 'جامعة النور',
            'site_tagline' => 'التعليم · البحث · خدمة المجتمع',
            'contact_email' => 'info@university.edu',
            'contact_phone' => '021-3334455',
            'contact_address' => 'طرابلس، ليبيا',
            'about_short' => 'جامعة النور مؤسسة تعليمية رائدة تلتزم بإعداد كوادر مؤهلة قادرة على الإسهام في التنمية وبناء المعرفة عبر برامج أكاديمية متميزة وبيئة بحثية محفّزة.',
            'students_count' => '12000+',
            'faculties_count' => '8',
            'programs_count' => '42',
            'years_count' => '35',
            'facebook' => 'https://facebook.com',
            'twitter' => 'https://x.com',
            'instagram' => 'https://instagram.com',
            'youtube' => 'https://youtube.com',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        Slider::query()->updateOrCreate(
            ['title' => 'مرحباً بكم في جامعة النور'],
            [
                'subtitle' => 'نحو تعليم عالٍ يواكب المستقبل ويبني الإنسان',
                'button_text' => 'القبول والتسجيل',
                'button_link' => '/admissions',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Slider::query()->updateOrCreate(
            ['title' => 'بيئة أكاديمية محفّزة'],
            [
                'subtitle' => 'كليات متعددة وبرامج حديثة وخدمات طلابية متكاملة',
                'button_text' => 'استكشف الكليات',
                'button_link' => '/faculties',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );

        $faculties = [
            ['name' => 'كلية الهندسة', 'slug' => 'engineering', 'dean' => 'د. أحمد المنصوري', 'students_count' => 2100, 'departments_count' => 6, 'sort_order' => 1],
            ['name' => 'كلية الطب', 'slug' => 'medicine', 'dean' => 'د. سعاد الزوي', 'students_count' => 1800, 'departments_count' => 5, 'sort_order' => 2],
            ['name' => 'كلية تقنية المعلومات', 'slug' => 'it', 'dean' => 'د. خالد العرفي', 'students_count' => 1600, 'departments_count' => 4, 'sort_order' => 3],
            ['name' => 'كلية العلوم', 'slug' => 'science', 'dean' => 'د. فاطمة الشريف', 'students_count' => 1400, 'departments_count' => 5, 'sort_order' => 4],
            ['name' => 'كلية الاقتصاد', 'slug' => 'economics', 'dean' => 'د. محمد التومي', 'students_count' => 2200, 'departments_count' => 4, 'sort_order' => 5],
            ['name' => 'كلية الآداب', 'slug' => 'arts', 'dean' => 'د. نادية القماطي', 'students_count' => 1900, 'departments_count' => 7, 'sort_order' => 6],
        ];

        foreach ($faculties as $faculty) {
            Faculty::query()->updateOrCreate(
                ['slug' => $faculty['slug']],
                array_merge($faculty, [
                    'description' => 'تقدم الكلية برامج أكاديمية متميزة تجمع بين الجانب النظري والتطبيقي، وتهدف إلى إعداد خريجين مؤهلين لسوق العمل وقادرين على الإسهام في البحث العلمي وخدمة المجتمع.',
                    'is_active' => true,
                ])
            );
        }

        News::query()->updateOrCreate(
            ['slug' => 'university-ranking'],
            [
                'title' => 'جامعة النور تحقق تقدماً في التصنيف الأكاديمي',
                'excerpt' => 'أعلنت الجامعة عن تحقيق تقدم ملحوظ في مؤشرات الجودة والبحث العلمي.',
                'content' => "أعلنت رئاسة جامعة النور عن تحقيق تقدم ملحوظ في التصنيف الأكاديمي الإقليمي، وذلك بفضل جهود أعضاء هيئة التدريس والباحثين والطلاب.\n\nويأتي هذا الإنجاز نتيجة خطط تطويرية شملت تحديث المناهج، ودعم المشاريع البحثية، وتعزيز الشراكات المحلية والدولية.",
                'is_published' => true,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ]
        );

        News::query()->updateOrCreate(
            ['slug' => 'open-day'],
            [
                'title' => 'اليوم المفتوح للطلبة الجدد',
                'excerpt' => 'تنظم الجامعة يوماً مفتوحاً للتعريف بالكليات وبرامج القبول.',
                'content' => "تنظم عمادة شؤون الطلاب يوماً مفتوحاً للطلبة الجدد وأولياء الأمور للتعريف بالكليات والخدمات الجامعية وآليات القبول والتسجيل.\n\nويتضمن البرنامج جولات تعريفية ومحاضرات إرشادية ومعارض للكليات.",
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ]
        );

        News::query()->updateOrCreate(
            ['slug' => 'research-conference'],
            [
                'title' => 'مؤتمر البحث العلمي السنوي',
                'excerpt' => 'دعوة للمشاركة في المؤتمر السنوي للبحث العلمي والابتكار.',
                'content' => "تعلن عمادة الدراسات العليا والبحث العلمي عن فتح باب المشاركة في المؤتمر السنوي للبحث العلمي والابتكار.\n\nويُرحب بالمشاركات البحثية من أعضاء هيئة التدريس وطلبة الدراسات العليا في مختلف التخصصات.",
                'is_published' => true,
                'is_featured' => false,
                'published_at' => now()->subDays(8),
            ]
        );

        Event::query()->updateOrCreate(
            ['slug' => 'orientation-week'],
            [
                'title' => 'أسبوع التعريف بالجامعة',
                'excerpt' => 'فعاليات تعريفية للطلبة المستجدين.',
                'content' => 'يشمل الأسبوع محاضرات تعريفية وورش عمل ولقاءات مع عمداء الكليات.',
                'location' => 'القاعة الكبرى - الحرم الجامعي',
                'starts_at' => now()->addDays(10)->setTime(10, 0),
                'ends_at' => now()->addDays(12)->setTime(15, 0),
                'is_published' => true,
            ]
        );

        Event::query()->updateOrCreate(
            ['slug' => 'career-fair'],
            [
                'title' => 'معرض التوظيف السنوي',
                'excerpt' => 'فرصة للتواصل مع جهات التوظيف المحلية.',
                'content' => 'يستضيف المعرض شركات ومؤسسات وطنية للتعريف بفرص التدريب والتوظيف للخريجين.',
                'location' => 'مركز المؤتمرات',
                'starts_at' => now()->addDays(25)->setTime(9, 0),
                'ends_at' => now()->addDays(26)->setTime(16, 0),
                'is_published' => true,
            ]
        );

        Page::query()->updateOrCreate(
            ['slug' => 'about'],
            [
                'title' => 'عن الجامعة',
                'content' => "تأسست جامعة النور لتكون منارة للعلم والمعرفة، وتعمل على تقديم تعليم عالٍ ذي جودة عالية يواكب التطورات العلمية والتقنية.\n\nتسعى الجامعة إلى بناء مجتمع معرفي من خلال تطوير البحث العلمي، وتعزيز الشراكة مع المؤسسات المحلية والدولية، وخدمة المجتمع بمبادرات تنموية مستدامة.\n\nرؤيتنا: أن نكون جامعة رائدة إقليمياً في التعليم والبحث والابتكار.\n\nرسالتنا: إعداد خريجين أكفاء قادرين على الإسهام في التنمية الشاملة، من خلال بيئة تعليمية محفّزة وبرامج أكاديمية متميزة.",
                'is_published' => true,
            ]
        );

        Page::query()->updateOrCreate(
            ['slug' => 'admissions'],
            [
                'title' => 'القبول والتسجيل',
                'content' => "مرحباً بكم في بوابة القبول والتسجيل بجامعة النور.\n\nشروط القبول العامة:\n1. الحصول على الشهادة الثانوية أو ما يعادلها.\n2. استيفاء النسبة المطلوبة حسب الكلية والتخصص.\n3. استكمال المستندات المطلوبة عبر نظام القبول الإلكتروني.\n\nالمستندات المطلوبة:\n- صورة من جواز السفر أو البطاقة الشخصية\n- كشف درجات الثانوية\n- صور شخصية حديثة\n- إيصال رسوم التقديم\n\nللاستفسار يمكنكم التواصل عبر صفحة اتصل بنا أو زيارة مكتب القبول والتسجيل في الحرم الجامعي خلال ساعات الدوام الرسمي.",
                'is_published' => true,
            ]
        );

        $facultyId = Faculty::query()->where('slug', 'engineering')->value('id');

        $demoStudent = Student::query()->updateOrCreate(
            ['registration_number' => '20260001'],
            [
                'secret_code' => '123456',
                'full_name' => 'أحمد محمد علي',
                'email' => 'student@university.edu',
                'phone' => '0912345678',
                'national_id' => '119900123456',
                'faculty_id' => $facultyId,
                'gender' => 'male',
                'status' => 'approved',
            ]
        );

        // Ensure known demo secret even if student already existed with different hash
        $demoStudent->forceFill(['secret_code' => '123456'])->save();

        $result = Result::query()->updateOrCreate(
            [
                'student_id' => $demoStudent->id,
                'academic_year' => '2025/2026',
                'semester' => 'الفصل الأول',
            ],
            [
                'gpa' => 3.25,
                'notes' => 'نتيجة تجريبية للعرض',
                'is_published' => true,
            ]
        );

        if ($result->subjects()->count() === 0) {
            foreach ([
                ['subject_name' => 'الرياضيات', 'grade' => '85', 'credits' => 3, 'status' => 'ناجح'],
                ['subject_name' => 'الفيزياء', 'grade' => '78', 'credits' => 3, 'status' => 'ناجح'],
                ['subject_name' => 'مقدمة في البرمجة', 'grade' => '92', 'credits' => 4, 'status' => 'ناجح'],
                ['subject_name' => 'اللغة الإنجليزية', 'grade' => '70', 'credits' => 2, 'status' => 'ناجح'],
            ] as $i => $subject) {
                $result->subjects()->create([
                    ...$subject,
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
