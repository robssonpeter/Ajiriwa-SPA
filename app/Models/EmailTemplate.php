<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class EmailTemplate extends Model
{
    use HasFactory;

    const TYPES_TABLES = [
        'interview_schedule' => [
            'tables' => ['candidates', 'jobs', 'interview_schedules', 'companies'],
            /*'index' => [
                'interviews' => 'application_id',
                'jobs' => 'id',
                'candidates' => 'id',
                'companies' => 'candidate:first_name'
            ],*/
            'sub_relation' => [
                'company_name' => ['table'=>'companies', 'column' => 'name'],
                'interview_date' => ['table'=>'interview_schedules', 'column' => 'date'],
                'interview_time' => ['table'=>'interview_schedules', 'column' => 'time'],
                'interview_venue' => ['table'=>'interview_schedules', 'column' => 'venue'],
            ],
            'app_relation' => [
                'interview_schedules' => 'interview',
                'jobs' => 'job',
                'candidates' => 'candidate',
                'companies' => 'company',
                'candidates' => 'candidate'
            ],
            'columns' => ['first_name', 'last_name', 'phone', 'title', 'interview_venue', 'interview_date', 'interview_time', 'company_name', 'notes'],
            'columns_to_placeholders' => [
                'name' => 'company_name',
                'title' => 'job_title',
                'notes' => 'note_to_candidate'
            ]
        ],
        'application_rejection' => [
            'tables' => ['candidates', 'jobs', 'companies'],
            'index' => [
                'jobs' => 'id',
                'candidates' => 'id',
                'company' => 'id',
            ],
            'sub_relation' => [
                'company_name' => ['table'=>'companies', 'column' => 'name'],
            ],
            'app_relation' => [
                'jobs' => 'job',
                'candidates' => 'candidate',
                'companies' => 'company'
            ],
            'columns' => ['first_name', 'last_name', 'title', 'name'],
            'columns_to_placeholders' => [
                'name' => 'company_name',
                'title' => 'job_title'
            ]
        ],
    ];
    const TYPES = [
        'interview_schedule', 'application_rejection'
    ];

    protected $fillable = [
        'company_id', 'name', 'content', 'type', 'created_by', 'is_default'
    ];


    public static function columnToPlaceholder($type, $column){
        $translations = self::TYPES_TABLES[$type]['columns_to_placeholders'];
        return $translations[$column]??$column;
    }

    /**
     * Converts the placeholde to appropriate column in the database.
     * 
     * @author Peter Mgembe
     * @param string $type This is equivalent to the type column on the model's table
     * @param string $placeholder name of the placeholder without boxed brackets
     */
    public static function placeholderToColumn($type, $placeholder){
        $translations = self::TYPES_TABLES[$type]['columns_to_placeholder'];
        return array_search($placeholder, $translations)??$placeholder;
    }

    public static function getColumnTable($type, $column){
        $tables = EmailTemplate::TYPES_TABLES[$type]['tables'];
        foreach($tables as $table){
            if(Schema::hasColumn($table, $column)){
                return $table;
            }
        }
        
        if(isset(EmailTemplate::TYPES_TABLES[$type]['sub_relation'][$column])){ // if sub-relation exist for the column
            $data = EmailTemplate::TYPES_TABLES[$type]['sub_relation'][$column]; // sub relation information;
            $return = $data['table'].':'.$data['column'];
            return $return;
        }
    }

    public static function placeholders($template_type){
        $columns = EmailTemplate::TYPES_TABLES[$template_type]['columns'];
        //return $columns;
        for($x = 0; $x < count($columns); $x++){
            $columns[$x] = '['.$columns[$x].']';
        }
        $placeholders = implode(', ', $columns);
        return $placeholders;
    }

    public static function typesAssoc(){
        $types = EmailTemplate::TYPES;
        $typesAssoc = [];
        foreach($types as $type){
            $typesAssoc[$type] = ucwords(str_replace('_', ' ', $type));
        }
        return $typesAssoc;
    }

    public static function renderTemplate($application_id, $template_id){
        $template = EmailTemplate::find($template_id);
        $tables = EmailTemplate::TYPES_TABLES;
        $types = EmailTemplate::TYPES;
        $application = JobApplication::where('id', $application_id);
        $withs = [];
        
        foreach($tables[$template->type]['tables'] as $table){
            $relation = $tables[$template->type]['app_relation'][$table];
            //array_push($withs, $relation);
            $application = $application->with($relation);
        }
        $application = $application->first();
        $contentTemplate = $template->content;
        $columns = $tables[$template->type]['columns'];
        $relation_prototypes = $tables[$template->type]['app_relation'];
        
        foreach($columns as $column){
            $columnTable = EmailTemplate::getColumnTable($template->type, $column);
            /*if($column == "name"){
                return $columnTable;
            }*/
            $bare_placeholder = self::columnToPlaceholder($template->type, $column); // placeholder withouth the boxed brackets
            $placeholder = '['.$bare_placeholder.']';
            if(!strpos($columnTable, ':')){ 
                /* if($column == "interview_venue"){
                    return 'hello';
                }  */ 

                $relation = $tables[$template->type]['app_relation'][$columnTable];
                $replacement = $application->$relation->$column;
            }else{
                // replace the . with : for better array creation
                $relation = str_replace('.', ':', $columnTable);
                $relations = explode(':', $relation);
                $replacement = $application;
                
                // Loop through the relations to make them as attributes
                foreach($relations as $relation){
                    $relation = $relation_prototypes[$relation]??$relation;
                    $replacement = $replacement->$relation;
                }
            }
            
            /* if($column == "title"){
                    return $placeholder ;
                } */
            $contentTemplate = str_replace($placeholder, $replacement, $contentTemplate);
        }
        return $contentTemplate;
    }
}
