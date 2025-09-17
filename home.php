<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Awareness</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        header {
            background-color: #007bff;
            color: #fff;;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: space-around;
            background: #333;
            color: white;
            padding: 0.5rem;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
        }
        nav a:hover {
            background: #575757;
            border-radius: 5px;
        }
        .container2 {
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
            transition: box-shadow 0.3s ease-in-out;
        }
        .card:focus-within, .card:active {
            box-shadow: 0 0 20px 4px rgba(0, 123, 255, 0.8);
        }
        .banner-heading {
            font-size: 1.8rem;
            color: #000;
            background: linear-gradient(to right, #03a9f4, #0288d1); /* Blue gradient */
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            position: relative;
            text-transform: uppercase;
            font-weight: bold;
            transform: skew(-5deg);
        }
        .banner-heading::before {
            content: '';
            position: absolute;
            top: 0;
            left: -10px;
            width: 20px;
            height: 100%;
            background: #0288d1; 
            clip-path: polygon(0 0, 100% 50%, 0 100%);
        }
        .banner-heading::after {
            content: '';
            position: absolute;
            top: 0;
            right: -10px;
            width: 20px;
            height: 100%;
            background: #03a9f4; 
            clip-path: polygon(100% 0, 0 50%, 100% 100%);
        }
        .card p {
            margin: 10px 0;
            color: #555;
        }
        .container {
            padding: 2rem;
        }
        .section {
            margin-bottom: 2rem;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .faq {
            margin: 2rem 0;
        }
        .faq h3 {
            margin: 1rem 0;
        }
        .faq p {
            margin: 0.5rem 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Inner Balance : Promoting awareness for mental health</h1>
</header>

<nav>
    <a href="home.php">Home</a>
    <a href="admin_login.php">Admin</a>
    <a href="doctor_registration.php">Psychologist</a>
    <a href="patient_registration.php">Patient</a>
    <a href="#faq">FAQ</a>
</nav>


</head>
<body>
<main class="container2">

<div class="card" tabindex="0">
    <h1 class="banner-heading">Major Depressive Disorder (MDD)</h1>
    <p><strong>Symptoms:</strong> Persistent sadness, loss of interest in activities, fatigue, sleep disturbances, changes in appetite, difficulty concentrating, feelings of worthlessness, thoughts of death or suicide.
In addition to the primary symptoms, people with MDD may experience physical symptoms like unexplained aches and pains. There may be feelings of guilt or hopelessness, as well as a significant reduction in daily functioning. Suicidal thoughts or actions are also common.
</p>
    <p><strong>Age Group:</strong> Common in adolescents and adults, with the first episode often occurring in late adolescence or early adulthood.</p>
    <p><strong>Risk Factors:</strong> Genetics, trauma, prolonged stress, chronic illness, and a family history of depression.
</p>
    <p><strong>Diagnosis:</strong>Diagnosed based on symptoms lasting for at least two weeks. A physical exam and lab tests may be conducted to rule out other causes of the symptoms.</p>
    <p><strong>Treatment:</strong> Antidepressant medications (SSRIs, SNRIs), psychotherapy (Cognitive Behavioral Therapy, CBT), lifestyle changes (exercise, healthy diet) , and sometimes electroconvulsive therapy (ECT) for severe cases.
</p>
</div>


<div class="card" tabindex="0">
    <h1 class="banner-heading">Bipolar I Disorder</h1>
    <p><strong>Symptoms:</strong> Episodes of mania (elevated mood, increased energy, impulsivity, grandiosity) and depression (low mood, loss of interest). Manic episodes may require hospitalization.
.</p>
    <p><strong>Age Group:</strong> Typically emerges in late adolescence or early adulthood.
</p>
    <p><strong>Diagnosis:</strong> Requires the presence of at least one manic episode lasting for at least a week. Depressive episodes may also be present but are not required for diagnosis.
</p>
    <p><strong>Treatment:</strong> Mood stabilizers (lithium), antipsychotic medications, psychotherapy, and lifestyle modifications.
</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Generalized Anxiety Disorder (GAD)</h1>
    <p><strong>Symptoms:</strong> Excessive worry about everyday life events, physical symptoms like restlessness, fatigue, muscle tension, difficulty concentrating, irritability, sleep problems.
.</p>
    <p><strong>Age Group:</strong> Can develop at any age, often beginning in childhood or adolescence.
</p>
    <p><strong>Risk Factors:</strong> Genetics, a history of trauma, childhood adversities, and excessive stress.
</p>
    <p><strong>Diagnosis:</strong> Diagnosis is made based on the presence of excessive worry occurring for more days than not over a period of six months, along with at least three other symptoms (fatigue, restlessness, etc.).</p>
    <p><strong>Treatment:</strong>Cognitive Behavioral Therapy (CBT), medications like SSRIs, benzodiazepines (for short-term relief), relaxation techniques.
</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Panic Disorder</h1>
    <p><strong>Symptoms:</strong>Recurrent panic attacks (sudden periods of intense fear or discomfort), heart palpitations, chest pain, sweating, chills, shortness of breath, dizziness.
</p>
    <p><strong>Age Group:</strong>Typically starts in late adolescence or early adulthood.
</p>
    <p><strong>Risk Factors:</strong>Trauma, or Stress and environmental influences can also play a role.</p>
    <p><strong>Diagnosis:</strong>Recurrent, unexpected panic attacks along with at least one month of persistent worry about having more attacks or behavioral changes to avoid attacks.</p>
    <p><strong>Treatment:</strong>  CBT, medications (SSRIs, SNRIs), exposure therapy, breathing exercises
.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Social Anxiety Disorder</h1>
    <p><strong>Symptoms:</strong>  Intense fear of social situations, excessive worry about being judged, physical symptoms like blushing, sweating, or shaking in social contexts.
</p>
    <p><strong>Age Group:</strong> Often starts in childhood or adolescence.</p>
    <p><strong>Risk Factors:</strong> Genetics, overprotective parenting, childhood teasing, environmental stress.</p>
    <p><strong>Diagnosis:</strong> Fear of social situations lasting at least six months, interfering with daily life.</p>
    <p><strong>Treatment:</strong> CBT, social skills training, medications (SSRIs, beta-blockers), exposure therapy.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Obsessive-Compulsive Disorder (OCD)</h1>
    <p><strong>Symptoms:</strong> Intrusive obsessions (recurrent, unwanted thoughts) and compulsions (repetitive behaviors or mental acts to relieve anxiety, e.g., washing, checking).
</p>
    <p><strong>Age Group:</strong> Can start in childhood, adolescence, or adulthood.</p>
    <p><strong>Diagnosis:</strong> Obsessions and compulsions must significantly impair daily functioning and be time-consuming (e.g., taking up more than an hour per day).</p>
    <p><strong>Treatment:</strong> Cognitive Behavioral Therapy (specifically Exposure and Response Prevention), medications (SSRIs), sometimes deep brain stimulation for severe cases.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Post-Traumatic Stress Disorder (PTSD)</h1>
    <p><strong>Symptoms:</strong> Flashbacks, nightmares, hypervigilance, avoidance of reminders, irritability, mood swings, negative thoughts.</p>
    <p><strong>Age Group:</strong> Can occur at any age, following exposure to trauma.</p>
    <p><strong>Risk Factors:</strong> A history of trauma, pre-existing mental health disorders, lack of social support, and family history of PTSD.</p>
    <p><strong>Diagnosis:</strong> The symptoms must last for more than a month and cause significant distress or functional impairment.</p>
    <p><strong>Treatment:</strong> Trauma-focused CBT, Eye Movement Desensitization and Reprocessing (EMDR), medications (SSRIs), support groups.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Schizophrenia</h1>
    <p><strong>Symptoms:</strong> Delusions (false beliefs), hallucinations (e.g., hearing voices), disorganized thinking and speech, negative symptoms (e.g., lack of motivation, reduced emotional expression).</p>
    <p><strong>Age Group:</strong> Typically emerges in late adolescence or early adulthood.</p>
    <p><strong>Risk Factors:</strong> Genetics, prenatal exposure to toxins or malnutrition, complications at birth, and environmental stressors.</p>
    <p><strong>Diagnosis:</strong> Presence of at least two of the core symptoms (delusions, hallucinations, disorganized speech, or behavior) for at least one month, with a continuous disturbance lasting six months.</p>
    <p><strong>Treatment:</strong> Antipsychotic medications, psychotherapy (family therapy, CBT), community support programs.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Autism Spectrum Disorder (ASD)</h1>
    <p><strong>Symptoms:</strong> Deficits in social communication, restrictive and repetitive behaviors, difficulty with transitions and changes.</p>
    <p><strong>Age Group:</strong> Diagnosed in early childhood (typically before age 3).</p>
    <p><strong>Risk Factors:</strong> Prenatal exposure to certain drugs, and advanced parental age.</p>
    <p><strong>Diagnosis:</strong> Symptoms typically emerge by age 3, with developmental screening, observation, and parent questionnaires aiding diagnosis.</p>
    <p><strong>Treatment:</strong> Behavioral therapies (Applied Behavior Analysis, ABA), speech and occupational therapy, medications to manage symptoms (e.g., irritability).</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Attention-Deficit/Hyperactivity Disorder (ADHD)</h1>
    <p><strong>Symptoms:</strong> Inattention, impulsivity, hyperactivity, difficulty staying organized or following instructions.</p>
    <p><strong>Age Group:</strong> Symptoms are often evident in early childhood, typically before age 12.</p>
    <p><strong>Risk Factors:</strong> Genetics, premature birth, lead exposure, and prenatal tobacco or alcohol use.</p>
    <p><strong>Diagnosis:</strong> Symptoms must be present for at least six months and cause impairment in at least two areas of life (e.g., school, home).</p>
    <p><strong>Treatment:</strong> Stimulant medications (e.g., methylphenidate), behavioral therapy, parent training, organizational strategies.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Antisocial Personality Disorder</h1>
    <p><strong>Symptoms:</strong> Disregard for others' rights, deceit, manipulation, lack of remorse, impulsivity, criminal behaviors.</p>
    <p><strong>Age Group:</strong> Typically diagnosed in adulthood (at least 18 years old), but patterns can begin in adolescence.</p>
    <p><strong>Risk Factors:</strong> Genetic predisposition, childhood abuse/neglect, brain abnormalities, and environmental factors like exposure to violence.</p>
    <p><strong>Diagnosis:</strong> Based on criteria in the DSM-5, often requiring a pattern of behavior for at least 3 years.</p>
    <p><strong>Treatment:</strong> Therapy (specifically cognitive-behavioral), sometimes medications for co-occurring conditions.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Alzheimer’s Disease</h1>
    <p><strong>Symptoms:</strong> Memory loss, confusion, difficulty completing familiar tasks, changes in mood and behavior.</p>
    <p><strong>Age Group:</strong> Primarily affects older adults, with symptoms typically emerging after age 65.</p>
    <p><strong>Risk factors:</strong> Age, genetics (e.g., APOE4 gene), head injuries, cardiovascular health, and lack of mental stimulation.</p>
    <p><strong>Diagnosis:</strong> Based on clinical evaluation, cognitive tests, brain scans, and genetic testing.</p>
    <p><strong>Treatment:</strong> No cure, but medications like cholinesterase inhibitors (Donepezil) may help slow progression. Supportive care, memory training, and safety modifications are important.</p>
</div>

<div class="card" tabindex="0">
    <h1 class="banner-heading">Delirium</h1>
    <p><strong>Symptoms:</strong> Sudden confusion, disorientation, difficulty focusing, hallucinations, disturbed sleep, fluctuating consciousness.</p>
    <p><strong>Age affected:</strong> Can occur at any age but is more common in older adults, especially in those with preexisting health conditions.</p>
    <p><strong>Risk factors:</strong> Hospitalization, infections, dehydration, medications (especially sedatives or painkillers), alcohol withdrawal, and pre-existing cognitive impairments.</p>
    <p><strong>Diagnosis:</strong> Based on clinical observation, mental status exams, and ruling out underlying causes (e.g., infections, metabolic issues).</p>
    <p><strong>Treatment:</strong> Focuses on treating the underlying cause (e.g., infection, dehydration), managing symptoms, and providing a calm environment. Delirium typically resolves once the cause is addressed.</p>
</div>
<div class="container">
    <section id="faq" class="faq">
        <h2>Frequently Asked Questions</h2>

        <h3>Q: What is the purpose of this platform?</h3>
        <p>A: This platform aims to promote mental health awareness and provide a space for patients, psychologists, and administrators to interact effectively.</p>

        <h3>Q: How can I book an appointment?</h3>
        <p>A: Patients can book appointments through the Patient Portal by selecting a psychologist and choosing an available time slot.</p>

        <h3>Q: How do psychologists share resources with patients?</h3>
        <p>A: Psychologists can upload articles and guides directly through their dashboard, which patients can access in the Resource section.</p>

        <h3>Q: How does the admin manage the platform?</h3>
        <p>A: The admin has access to a dedicated dashboard for managing user accounts, monitoring appointments, and publishing content.</p>

        <h3>Q: Are my personal details secure?</h3>
        <p>A: Yes, we prioritize your privacy and use secure protocols to ensure all personal and medical information remains confidential.</p>
    </section>
</div>


</body>
</html>