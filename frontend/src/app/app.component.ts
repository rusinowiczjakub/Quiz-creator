import {Component, OnInit} from '@angular/core';
import {Question} from "./Question";
import {QuestionService} from "./question.service";
import {Answer} from "./Answer";
import { animate, style, transition, trigger, query, stagger } from "@angular/animations";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  animations: [
    trigger("loadAnimation", [
      transition('* => *', [

        query(':enter', style({ opacity: 0 }), {optional: true}),

        query(':enter', stagger('100ms', [
          animate('0.3s linear', style({
              opacity: 1
            })
          )
        ]), {
          optional: true
        })
      ])
    ])
  ]
})
export class AppComponent{
  question: Question;
  questionsIds = [];
  correctAnswers: number = 0;
  sliderValue: number = 1;
  isDone: boolean = false;

  constructor(private questionService: QuestionService) {
  }

  showQuestion() {
    if (this.questionsIds.length < this.sliderValue) {
      this.questionService.getQuestion().subscribe((data: Question) => {
        if (this.questionsIds.indexOf(data.id) !== -1) {
          this.showQuestion();
        } else {
          this.question = data;
          this.question.answers.forEach((e) => {
            e.isChecked = false;
          });

          this.questionsIds.push(this.question.id);
        }
      });
    } else {
      this.isDone = true;
    }
  }

  checkAnswer(elem: Answer) {
    elem.isChecked = true;

    this.question.answers.forEach((e) => {
      if (e.isCorrect) {
        e.isChecked = true;
      }
    });

    if (elem.isCorrect) {
      this.correctAnswers++;
    }

    setTimeout(() => {
      this.question = null;
      this.showQuestion();
    }, 1000)
  }

  changeSliderVal(e) {
    this.sliderValue = e.target.value;
  }

  getResult() {
    return this.correctAnswers / this.questionsIds.length * 100;
  }

  reset() {
    this.question = null;
    this.questionsIds = [];
    this.correctAnswers = 0;
    this.sliderValue = 1;
    this.isDone = false;
  }
}
