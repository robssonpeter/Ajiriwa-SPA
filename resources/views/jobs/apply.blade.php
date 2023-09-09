@extends('layouts.app')
@section('content')
<div class="min-h-screen flex items-center justify-center" id="apply-page">
    <div class="bg-white shadow-md rounded-lg p-8 w-96">
        <h2 class="text-2xl font-semibold mb-4">Job Application Form</h2>
        <form @submit.prevent="apply">
            <apply :candidate="Number('{{ $candidate->id }}')" @applied="doneApplying" @applying="applying" :selected_certs="selected_certs"
                :assessments="current_assessments" :job="current_job" :ref="'apply'"></apply>
            <section class="flex flex-col py-2">
                <span class="font-bold">Attachments</span>
                <v-select :options="certificates" v-model="selected_certs" multiple></v-select>
            </section>
            <div v-if="current_assessments.length">
                <assessment-render @changed="questionAnswered" v-for="question in current_assessments"
                    :question="question"></assessment-render>
            </div>
            <button type="submit" class="hidden" ref="submit-application">send</button>
        </form>
    </div>
</div>
<script>
    let certificates = @json($certificates)

    let job = @json($job)

    let assessmentUrl = "{{ route('job.assessment.get') }}";

    alert(assessmentUrl);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.0/axios.min.js" integrity="sha512-aoTNnqZcT8B4AmeCFmiSnDlc4Nj/KPaZyB5G7JnOnUEkdNpCZs1LCankiYi01sLTyWy+m2P+W4XM+BuQ3Q4/Dg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ mix('js/apply.js') }}"></script>
@endsection