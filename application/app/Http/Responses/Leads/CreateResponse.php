<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [create] process for the leads
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Leads;
use Illuminate\Contracts\Support\Responsable;

class CreateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for team members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {
        // Establecer todos los datos en arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }
    
        // Renderizar el formulario
        $html = view('pages/leads/components/modals/add-edit-inc', compact('page', 'categories', 'tags', 'statuses', 'sources', 'fields', 'clients'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html);
    
        // Mostrar pie de página del modal
        $jsondata['dom_visibility'][] = array('selector' => '#commonModalFooter', 'action' => 'show');
    
        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXLeadCreate',
        ];
    
        // Respuesta AJAX
        return response()->json($jsondata);
    }    

}
