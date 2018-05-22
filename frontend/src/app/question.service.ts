import { Injectable } from '@angular/core';
import {HttpClient} from "@angular/common/http";

@Injectable()
export class QuestionService {

  constructor(private http: HttpClient) { }

  getQuestion() {
    return this.http.get('http://127.0.0.1:8000/api/question')
  }
}
